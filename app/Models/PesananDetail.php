<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    protected $table = 'pesanan_detail';
    protected $guarded = [];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
