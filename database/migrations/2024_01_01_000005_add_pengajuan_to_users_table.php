<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('alasan_pengajuan')->nullable()->after('kelas');
            $table->enum('status_akun', ['pending', 'approved', 'rejected'])
                  ->default('pending')->after('is_approved');
            $table->text('catatan_penolakan')->nullable()->after('status_akun');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alasan_pengajuan', 'status_akun', 'catatan_penolakan']);
        });
    }
};