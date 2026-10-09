<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Menyesuaikan dengan nama tabel di database Anda
    protected $table = 'user';

    // Kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'nama_lengkap',
        'username', // Digunakan untuk menyimpan email
        'jenis_kelamin',
        'no_telp',
        'password',
        'role',
        'google_id',
        'alamat',
    ];

    // Kolom yang disembunyikan
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
