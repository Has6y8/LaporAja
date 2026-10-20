<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6|confirmed',
            'nisn_nip'         => 'nullable|string|max:30', // <-- Ubah ke nisn_nip
            'kelas'            => 'nullable|string|max:30',
            'no_telepon'       => 'nullable|string|max:20',
            'alasan_pengajuan' => 'nullable|string|max:500',
        ]);

        $data['password']    = Hash::make($data['password']);
        $data['role']        = 'user';
        $data['is_approved'] = false;
        $data['status_akun'] = 'pending';

        User::create($data);

        return redirect()->route('login')
            ->with('success', 'Pengajuan akun berhasil dikirim! Tunggu konfirmasi dari Super Admin.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        if ($user->status_akun === 'pending') {
            return back()->withErrors([
                'email' => 'Akun Anda masih menunggu konfirmasi Super Admin.',
            ])->onlyInput('email');
        }

        if ($user->status_akun === 'rejected') {
            $msg = 'Pengajuan akun Anda ditolak.';
            if ($user->catatan_penolakan) {
                $msg .= ' Alasan: ' . $user->catatan_penolakan;
            }
            return back()->withErrors(['email' => $msg])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}