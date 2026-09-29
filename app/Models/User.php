<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'nis_nip', 'kelas', 'no_telepon', 'is_approved',
        'alasan_pengajuan', 'status_akun', 'catatan_penolakan',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'    => 'hashed',
        'is_approved' => 'boolean',
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
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'admin'       => 'Admin',
            'staff'       => 'Staff',
            default       => 'Siswa / Guru',
        };
    }
}