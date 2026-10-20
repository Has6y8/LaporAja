<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'             => 'Super Admin',
            'email'            => 'super@laporaja.id',
            'password'         => Hash::make('super123'),
            'role'             => 'super_admin',
            'is_approved'      => true,
            'status_akun'      => 'approved',
            'can_manage_users' => true, // <-- Super admin punya akses
        ]);

        User::create([
            'name'             => 'Admin Sekolah',
            'email'            => 'admin@laporaja.id',
            'password'         => Hash::make('admin123'),
            'role'             => 'admin',
            'is_approved'      => true,
            'status_akun'      => 'approved',
            'can_manage_users' => false, // <-- Admin biasa TIDAK punya akses
        ]);

        User::create([
            'name'         => 'Staff Sarpras',
            'email'        => 'staff@laporaja.id',
            'password'     => Hash::make('staff123'),
            'role'         => 'staff',
            'is_approved'  => true,
            'status_akun'  => 'approved',
        ]);

        User::create([
            'name'         => 'Pranaja Abi Praya',
            'email'        => 'user@laporaja.id',
            'password'     => Hash::make('user123'),
            'role'         => 'user',
            'tipe_user'    => 'siswa',
            'nisn_nip'     => '27',
            'kelas'        => 'XII RPL C',
            'no_telepon'   => '08123456789',
            'is_approved'  => true,
            'status_akun'  => 'approved',
        ]);
    }
}