<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // Fungsi untuk menampilkan daftar katalog
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                    ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('sort') && $request->sort != '') {
            if ($request->sort == 'terendah') {
                $query->orderBy('harga', 'asc');
            } elseif ($request->sort == 'tertinggi') {
                $query->orderBy('harga', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $produk = $query->paginate(50)->withQueryString();
        $produkTerbaru = Produk::latest()->first();

        return view('katalog.index', compact('produk', 'produkTerbaru'));
    }

    // Fungsi BARU untuk menampilkan detail produk
    public function show($id)
    {
        // Cari produk berdasarkan ID, jika tidak ada munculkan error 404
        $produk = Produk::findOrFail($id);

        return view('katalog.show', compact('produk'));
    }
}
