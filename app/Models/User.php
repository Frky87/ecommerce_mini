<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user'; // Penegasan nama tabel

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'jenis_kelamin',
        'no_telp',
        'alamat',
        'role'
    ];

    protected $hidden = [
        'password',
    ];
}
