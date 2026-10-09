<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $guarded = [];

    // Relasi ke tabel pesanan_detail (1 Pesanan punya banyak Detail)
    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }

    // Relasi ke tabel user (1 Pesanan dimiliki oleh 1 User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
