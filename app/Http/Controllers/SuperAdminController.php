<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function approvals()
    {
        $pendingUsers = User::where('status_akun', 'pending')
            ->where('role', '!=', 'super_admin')
            ->latest()->get();

        $allUsers = User::where('role', '!=', 'super_admin')
            ->latest()->get();

        return view('super.approvals', compact('pendingUsers', 'allUsers'));
    }

    public function approve(User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin tidak bisa di-approve.');
        }

        $user->update([
            'status_akun' => 'approved',
            'is_approved' => true,
        ]);

        return back()->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject(Request $request, User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin tidak bisa ditolak.');
        }

        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        $user->update([
            'status_akun'        => 'rejected',
            'catatan_penolakan'  => $request->catatan,
        ]);

        return back()->with('success', "Pengajuan akun {$user->name} ditolak.");
    }
}