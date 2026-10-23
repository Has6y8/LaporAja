<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Komplain;
use App\Models\StatusLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
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
        ]);

        // FIX: 'tolak_laporan' -> status komplain = 'ditolak'
        //      selain itu -> status komplain = 'direspon'
        $statusKomplain = $data['aksi'] === 'tolak_laporan' ? 'ditolak' : 'direspon';

        $komplain->update([
            'respon_admin' => $data['respon_admin'],
            'admin_id'     => auth()->id(),
            'respon_at'    => now(),
            'status'       => $statusKomplain,
        ]);

        if ($data['aksi'] === 'tolak_laporan') {
            // FIX: HANYA menolak komplain. Status laporan TIDAK diubah.
            return back()->with('success', 'Komplain berhasil ditolak. Status laporan tidak berubah.');

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

    public function userIndex()
    {
        $users = User::where('role', '!=', 'super_admin')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function userStore(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required|in:user,staff,admin',
            'tipe_user'  => 'nullable|in:siswa,guru',
            'nisn_nip'   => 'nullable|string',
            'kelas'      => 'nullable|string',
            'jabatan'    => 'nullable|string',
            'no_telepon' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($data['role'] === 'user') {
            $data['status_akun'] = 'approved';
            $data['is_approved'] = true;
        } elseif ($data['role'] === 'staff') {
            $data['status_akun'] = 'approved';
            $data['is_approved'] = true;
            $data['tipe_user'] = null;
            $data['kelas']     = null;
        } else {
            $data['status_akun'] = 'pending';
            $data['is_approved'] = false;
            $data['tipe_user'] = null;
            $data['kelas']     = null;
        }

        User::create($data);
        
        $msg = $data['role'] === 'admin' ? "Admin {$data['name']} diajukan. Menunggu approval." : "User {$data['name']} berhasil ditambahkan.";
        return back()->with('success', $msg);
    }

    public function userUpdate(Request $request, User $user)
    {
        // Super Admin tidak bisa diedit oleh Admin biasa
        if ($user->role === 'super_admin' && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang bisa mengedit Super Admin.');
        }

        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'        => 'required|in:user,staff,admin',
            'tipe_user'   => 'nullable|in:siswa,guru',
            'nisn_nip'    => 'nullable|string',
            'kelas'       => 'nullable|string',
            'jabatan'     => 'nullable|string',
            'no_telepon'  => 'nullable|string',
            'status_akun' => 'required|in:pending,approved,rejected',
        ]);

        if ($data['role'] === 'user') {
            $data['is_approved'] = $data['status_akun'] === 'approved';
        } elseif ($data['role'] === 'staff') {
            $data['status_akun'] = 'approved';
            $data['is_approved'] = true;
            $data['tipe_user'] = null;
            $data['kelas']     = null;
        } else {
            $data['is_approved'] = $data['status_akun'] === 'approved';
            $data['tipe_user'] = null;
            $data['kelas']     = null;
        }
        
        $user->update($data);

        return back()->with('success', "Data user {$user->name} berhasil diperbarui.");
    }

    public function toggleManageUsers(User $user)
    {
        // Hanya Super Admin yang bisa mengakses ini
        if (!auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang bisa memberikan izin ini.');
        }

        // Jangan sampai menurunkan derajat Super Admin
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Tidak bisa mengubah izin Super Admin.');
        }

        // Hanya bisa diberikan ke Admin
        if ($user->role !== 'admin') {
            return back()->with('error', 'Izin ini hanya bisa diberikan ke Admin.');
        }

        $user->update([
            'can_manage_users' => !$user->can_manage_users
        ]);

        $status = $user->can_manage_users ? 'diberikan' : 'dicabut';
        return back()->with('success', "Izin kelola user berhasil {$status} untuk {$user->name}.");
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