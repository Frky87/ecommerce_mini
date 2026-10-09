<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori',
        'harga',
        'stok',
        'foto'
    ];

    // Fungsi membaca gambar (Tahan banting untuk data lama & baru)
    public function getFotoArrayAttribute()
    {
        $foto = $this->foto;
        // Jika kosong, kembalikan array kosong
        if (empty($foto) || $foto === 'null' || $foto === '[]') {
            return [];
        }

        // Coba baca sebagai JSON (multi-gambar)
        $decoded = json_decode($foto, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Jika data lama (cuma 1 gambar berupa teks biasa)
        return [$foto];
    }
}
