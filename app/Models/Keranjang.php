<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $fillable = ['user_id', 'produk_id', 'kuantitas'];

    // Relasi ke tabel produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
