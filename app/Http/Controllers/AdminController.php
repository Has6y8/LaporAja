<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Komplain;
use App\Models\StatusLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'Rekap_Laporan_LaporAja_' . date('Ymd_His') . '.csv', \Maatwebsite\Excel\Excel::CSV);
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
            // NISN/NIP sekarang WAJIB dan UNIQUE (tidak boleh ada yang sama)
            'nisn_nip'   => 'required|string|unique:users,nisn_nip', 
            'kelas'      => 'nullable|string',
            'jabatan'    => 'nullable|string',
            'no_telepon' => 'nullable|string',
        ], [
            'nisn_nip.required' => 'NISN / NIP wajib diisi.',
            'nisn_nip.unique'   => 'NISN / NIP ini sudah terdaftar di sistem.',
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
            // NISN/NIP WAJIB diisi, dan mengabaikan ID user saat ini agar tidak error saat edit data dirinya sendiri
            'nisn_nip'    => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'kelas'       => 'nullable|string',
            'jabatan'     => 'nullable|string',
            'no_telepon'  => 'nullable|string',
            'status_akun' => 'required|in:pending,approved,rejected',
        ], [
            'nisn_nip.required' => 'NISN / NIP wajib diisi.',
            'nisn_nip.unique'   => 'NISN / NIP ini sudah terdaftar di sistem.',
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