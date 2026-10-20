<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    protected $fillable = [
        'laporan_id', 'user_id', 'tipe', 'isi',
        'status', 'admin_id', 'respon_admin', 'respon_at', 'read_at',
    ];

    protected $casts = [
        'respon_at' => 'datetime',
        'read_at'   => 'datetime',
    ];

    public function laporan() { return $this->belongsTo(Laporan::class); }
    public function user()    { return $this->belongsTo(User::class, 'user_id'); }
    public function admin()   { return $this->belongsTo(User::class, 'admin_id'); }

    public function getTipeLabelAttribute(): string
    {
        return match ($this->tipe) {
            'lambat_respon'           => 'Respon / Pengerjaan Lambat',
            'pengerjaan_tidak_sesuai' => 'Pengerjaan Tidak Sesuai',
            'kurang_jelas'            => 'Laporan Kurang Jelas',
            'foto_tidak_pantas'       => 'Foto Tidak Pantas',
            'kata_kasar'              => 'Mengandung Kata Kasar',
            'minta_hapus_laporan'     => 'Minta Hapus Laporan',
            'lainnya'                 => 'Lainnya',
            default                   => 'Unknown',
        };
    }
}