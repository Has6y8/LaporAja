<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin - TIDAK BISA DIHAPUS & TIDAK BISA DIPEGANG SIAPA PUN
        User::create([
            'name'        => 'Super Admin',
            'email'       => 'super@laporaja.id',
            'password'    => Hash::make('super123'),
            'role'        => 'super_admin',
            'is_approved' => true,
        ]);

        // Admin Sekolah
        User::create([
            'name'        => 'Admin Sekolah',
            'email'       => 'admin@laporaja.id',
            'password'    => Hash::make('admin123'),
            'role'        => 'admin',
            'is_approved' => true,
        ]);

        // Staff Sarpras
        User::create([
            'name'        => 'Staff Sarpras',
            'email'       => 'staff@laporaja.id',
            'password'    => Hash::make('staff123'),
            'role'        => 'staff',
            'is_approved' => true,
        ]);

        // User / Siswa
        User::create([
            'name'        => 'Pranaja Abi Praya',
            'email'       => 'user@laporaja.id',
            'password'    => Hash::make('user123'),
            'role'        => 'user',
            'nis_nip'     => '27',
            'kelas'       => 'XII RPL C',
            'no_telepon'  => '08123456789',
            'is_approved' => true,
        ]);
    }
}