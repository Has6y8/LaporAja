<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: IT, Bangunan, Kelistrikan
            $table->timestamps();
        });

        // Tambahkan kolom staff_type_id ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('staff_type_id')->nullable()->constrained('staff_types')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['staff_type_id']);
            $table->dropColumn('staff_type_id');
        });
        Schema::dropIfExists('staff_types');
    }
};