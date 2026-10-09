<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_telp', 20);
            $table->text('alamat');
            $table->enum('role', ['admin', 'super admin', 'user'])->default('user');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
