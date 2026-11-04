<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Komplain;
use App\Models\StatusLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $rules = [
            'status'  => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'required|string|max:1000',
        ];
        
        if ($request->status === 'selesai') {
            $rules['foto_perbaikan'] = 'required|image|mimes:jpg,jpeg,png|max:5120';
        } else {
            $rules['foto_perbaikan'] = 'nullable|image|mimes:jpg,jpeg,png|max:5120';
        }
        
        $data = $request->validate($rules, [
            'foto_perbaikan.required' => 'Foto bukti perbaikan wajib diunggah saat status Selesai.',
            'catatan.required'        => 'Catatan wajib diisi sebagai informasi untuk pelapor.',
        ]);
        
        $update = [
            'status'        => $data['status'],
            'staff_id'      => auth()->id(),
            'catatan_staff' => $data['catatan'],
        ];
        
        if ($request->hasFile('foto_perbaikan')) {
            $image = $request->file('foto_perbaikan');
            $manager = new ImageManager(new Driver());
            $compressedImage = $manager->read($image)->scaleDown(width: 800)->toJpeg(60);
            $update['foto_perbaikan'] = 'data:image/jpeg;base64,' . base64_encode((string) $compressedImage);
        }
        
        $laporan->update($update);
        
        StatusLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'status'     => $data['status'],
            'keterangan' => $data['catatan'],
        ]);
        
        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'Rekap_Laporan_LaporAja_' . date('Ymd_His') . '.xlsx');
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

        $statusKomplain = $data['aksi'] === 'tolak_laporan' ? 'ditolak' : 'direspon';

        $komplain->update([
            'respon_admin' => $data['respon_admin'],
            'admin_id'     => auth()->id(),
            'respon_at'    => now(),
            'status'       => $statusKomplain,
        ]);

        if ($data['aksi'] === 'tolak_laporan') {
            return back()->with('success', 'Komplain berhasil ditolak. Status laporan tidak berubah.');
        } elseif ($data['aksi'] === 'hapus_laporan') {
            $laporan = $komplain->laporan;
            if ($laporan) {
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
            $data['status_akun'] = 'approved'; 
            $data['is_approved'] = true;
            $data['tipe_user'] = null;
            $data['kelas']     = null;
        }

        User::create($data);
        
        return back()->with('success', "User {$data['name']} berhasil ditambahkan.");
    }

    public function userUpdate(Request $request, User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Akun Super Admin tidak dapat diedit.');
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

    public function userDestroy(User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin tidak dapat dihapus.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}