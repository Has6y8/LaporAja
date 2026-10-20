<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'tipe_user', 'can_manage_users',
        'nisn_nip', 'kelas', 'jabatan', 'no_telepon', 'is_approved',
        'alasan_pengajuan', 'status_akun', 'catatan_penolakan',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'         => 'hashed',
        'is_approved'      => 'boolean',
        'can_manage_users' => 'boolean', // <-- Tambahkan ini
    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function komplains()
    {
        return $this->hasMany(Komplain::class);
    }

    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isAdmin(): bool      { return in_array($this->role, ['admin', 'super_admin']); }
    public function isStaff(): bool      { return $this->role === 'staff'; }
    public function isUser(): bool       { return $this->role === 'user'; }

    public function roleLabel(): string
    {
        if ($this->role === 'user') {
            return $this->tipe_user === 'guru' ? 'Guru' : 'Siswa';
        }
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'admin'       => 'Admin',
            'staff'       => 'Staff',
            default       => 'User',
        };
    }
}