<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'user_id', 'judul', 'deskripsi', 'lokasi',
        'foto_bukti', 'foto_perbaikan', 'status',
        'staff_id', 'catatan_staff',
        'verified_by', 'verified_at', 'moderation_status', 'alasan_moderasi',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()         { return $this->belongsTo(User::class, 'user_id'); }
    public function staff()        { return $this->belongsTo(User::class, 'staff_id'); }
    public function verifier()     { return $this->belongsTo(User::class, 'verified_by'); }
    public function statusLogs()   { return $this->hasMany(StatusLaporan::class); }
    public function komplains()    { return $this->hasMany(Komplain::class); }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending'  => ['label' => 'Pending',  'color' => 'amber'],
            'diproses' => ['label' => 'Diproses', 'color' => 'blue'],
            'selesai'  => ['label' => 'Selesai',  'color' => 'green'],
            'ditolak'  => ['label' => 'Ditolak',  'color' => 'red'],
            default    => ['label' => 'Unknown',  'color' => 'gray'],
        };
    }

    public function getModerationBadgeAttribute(): array
    {
        return match ($this->moderation_status) {
            'pending'  => ['label' => 'Menunggu Verifikasi', 'color' => 'amber'],
            'approved' => ['label' => 'Terverifikasi',       'color' => 'green'],
            'rejected' => ['label' => 'Ditolak Admin',       'color' => 'red'],
            default    => ['label' => 'Unknown',             'color' => 'gray'],
        };
    }
}