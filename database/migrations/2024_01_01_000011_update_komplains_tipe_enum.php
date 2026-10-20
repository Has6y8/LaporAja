<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'pengerjaan_tidak_sesuai' untuk user
        DB::statement("ALTER TABLE komplains MODIFY COLUMN tipe ENUM(
            'lambat_respon',
            'pengerjaan_tidak_sesuai',
            'kurang_jelas',
            'foto_tidak_pantas',
            'kata_kasar',
            'minta_hapus_laporan',
            'lainnya'
        )");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE komplains MODIFY COLUMN tipe ENUM(
            'lambat_respon',
            'kurang_jelas',
            'foto_tidak_pantas',
            'kata_kasar',
            'minta_hapus_laporan',
            'lainnya'
        )");
    }
};