<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            // Kolom penanda status pengajuan
            $table->enum('pengajuan_toko', ['-', 'pending', 'diterima', 'ditolak'])->default('-');
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('pengajuan_toko');
        });
    }
};
