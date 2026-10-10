<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'JEREMY',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '08123456788',
            'alamat' => 'Malang',
            'deskripsi' => 'Toko barokah',
            'nama_toko' => 'Abadi nan jaya',
            'role' => 'super admin',
            'pengajuan_toko' => '-'
        ]);
    }
}
