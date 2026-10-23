<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'ditolak' ke dalam enum status komplain
        DB::statement("ALTER TABLE komplains MODIFY COLUMN status ENUM('pending', 'direspon', 'ditolak') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE komplains MODIFY COLUMN status ENUM('pending', 'direspon') DEFAULT 'pending'");
    }
};