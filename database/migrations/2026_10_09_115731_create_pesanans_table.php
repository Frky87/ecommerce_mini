<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('kode_pesanan')->unique();
            $table->text('alamat_pengiriman');
            $table->integer('ongkir');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->string('metode_pembayaran');
            $table->enum('status', ['Belum Dibayar', 'Sudah Dibayar', 'Dikirim', 'Selesai'])->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
