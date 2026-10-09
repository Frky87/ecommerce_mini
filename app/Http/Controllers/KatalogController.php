<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%')
                ->orWhere('kategori', 'like', '%' . $request->search . '%');
        }
        $produk = $query->get();
        // File view katalog.index merujuk pada kode HTML Landing Page yang saya berikan sebelumnya
        return view('katalog.index', compact('produk'));
    }
}
