<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Komplain;
use App\Models\StatusLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ============================================
    // VERIFIKASI LAPORAN (SUPERVISOR)
    // ============================================
    public function verifikasiIndex()
    {
        $laporans = Laporan::where('moderation_status', 'pending')
            ->where('status', 'pending')
            ->latest()->get();

        return view('admin.verifikasi', compact('laporans'));
    }

    public function verifikasi(Request $request, Laporan $laporan)
    {
        // Blokir kalau staff sudah mulai proses
        if ($laporan->status !== 'pending') {
            return back()->with('error',
                'Laporan sudah diproses staff. Verifikasi tidak bisa dilakukan lagi.'
            );
        }

        $data = $request->validate([
            'moderation_status' => 'required|in:approved,rejected',
            'alasan_moderasi'   => 'nullable|string|max:500',
        ]);

        if ($data['moderation_status'] === 'rejected' && empty($data['alasan_moderasi'])) {
            return back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $laporan->update([
            'moderation_status' => $data['moderation_status'],
            'alasan_moderasi'   => $data['alasan_moderasi'] ?? null,
            'verified_by'       => auth()->id(),
            'verified_at'       => now(),
        ]);

        if ($data['moderation_status'] === 'rejected') {
            $laporan->update(['status' => 'ditolak']);
        }

        StatusLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'status'     => $laporan->status,
            'keterangan' => $data['moderation_status'] === 'approved'
                ? 'Laporan diverifikasi oleh admin.'
                : 'Laporan ditolak admin: ' . $data['alasan_moderasi'],
        ]);

        return back()->with('success', 'Verifikasi laporan berhasil.');
    }

    // ============================================
    // UPDATE STATUS (Admin & Staff)
    // ============================================
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $rules = [
            'status'  => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ];

        if ($request->status === 'selesai') {
            $rules['foto_perbaikan'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        } else {
            $rules['foto_perbaikan'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        }

        $data = $request->validate($rules, [
            'foto_perbaikan.required' => 'Foto bukti perbaikan wajib diunggah saat status Selesai.',
        ]);

        $update = [
            'status'        => $data['status'],
            'staff_id'      => auth()->id(),
            'catatan_staff' => $data['catatan'] ?? null,
        ];

        if ($request->hasFile('foto_perbaikan')) {
            if ($laporan->foto_perbaikan && Storage::disk('public')->exists($laporan->foto_perbaikan)) {
                Storage::disk('public')->delete($laporan->foto_perbaikan);
            }
            $update['foto_perbaikan'] = $request->file('foto_perbaikan')->store('perbaikan', 'public');
        }

        $laporan->update($update);

        StatusLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'status'     => $data['status'],
            'keterangan' => $data['catatan'] ?? 'Status diperbarui.',
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    // ============================================
    // KOMPLAIN — ADMIN RESPON
    // ============================================
    public function komplainIndex()
    {
        $komplains = Komplain::latest()->get();
        return view('admin.komplain', compact('komplains'));
    }

    public function komplainRespon(Request $request, Komplain $komplain)
    {
        $data = $request->validate([
            'respon_admin' => 'required|string|max:1000',
            'aksi'         => 'required|in:respon_saja,tolak_laporan,hapus_laporan',
        ], [
            'aksi.required' => 'Pilih aksi terlebih dahulu.',
        ]);

        // Update komplain dulu
        $komplain->update([
            'respon_admin' => $data['respon_admin'],
            'admin_id'     => auth()->id(),
            'respon_at'    => now(),
            'status'       => 'direspon',
        ]);

        // Handle aksi
        if ($data['aksi'] === 'tolak_laporan') {
            $komplain->laporan->update([
                'status'            => 'ditolak',
                'moderation_status' => 'rejected',
                'alasan_moderasi'   => 'Ditolak atas permintaan staff: ' . $data['respon_admin'],
                'verified_by'       => auth()->id(),
                'verified_at'       => now(),
            ]);

            StatusLaporan::create([
                'laporan_id' => $komplain->laporan_id,
                'user_id'    => auth()->id(),
                'status'     => 'ditolak',
                'keterangan' => 'Laporan ditolak atas permintaan staff.',
            ]);

            return back()->with('success', 'Laporan ditolak. Tetap tersimpan di histori.');

        } elseif ($data['aksi'] === 'hapus_laporan') {
            $laporan = $komplain->laporan;

            if ($laporan) {
                if ($laporan->foto_bukti && Storage::disk('public')->exists($laporan->foto_bukti)) {
                    Storage::disk('public')->delete($laporan->foto_bukti);
                }
                if ($laporan->foto_perbaikan && Storage::disk('public')->exists($laporan->foto_perbaikan)) {
                    Storage::disk('public')->delete($laporan->foto_perbaikan);
                }

                $laporan->komplains()->delete();
                $laporan->statusLogs()->delete();
                $laporan->delete();
            }

            return back()->with('success', 'Laporan berhasil dihapus permanen.');
        }

        return back()->with('success', 'Respon komplain berhasil dikirim.');
    }

    // ============================================
    // KELOLA USER
    // ============================================
    public function userIndex()
    {
        $users = User::where('role', '!=', 'super_admin')
            ->latest()->get();

        return view('admin.users', compact('users'));
    }

    /**
     * Tambah user baru (Admin bisa tambah user, staff, atau admin)
     * - User & Staff → langsung approved
     * - Admin → pending, tunggu approval Super Admin
     */
    public function userStore(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required|in:user,staff,admin',
            'nis_nip'    => 'nullable|string',
            'kelas'      => 'nullable|string',
            'no_telepon' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);

        // Kalau admin → perlu approval Super Admin dulu
        if ($data['role'] === 'admin') {
            $data['status_akun'] = 'pending';
            $data['is_approved'] = false;

            User::create($data);

            return back()->with('success',
                "Admin {$data['name']} berhasil diajukan. Menunggu approval Super Admin."
            );
        }

        // User & Staff → langsung aktif
        $data['status_akun'] = 'approved';
        $data['is_approved'] = true;

        User::create($data);

        return back()->with('success', "User {$data['name']} berhasil ditambahkan.");
    }

    public function userDestroy(User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin tidak dapat dihapus.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}