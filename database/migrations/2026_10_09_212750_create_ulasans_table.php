<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            // Menyambungkan ke tabel pesanan, produk, dan user
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade'); // Ubah 'user' jadi 'users' jika tabel Anda menggunakan s

            // Kolom penilaian
            $table->integer('rating'); // 1 sampai 5 bintang
            $table->text('komentar');
            $table->string('foto_review')->nullable(); // Foto opsional

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
