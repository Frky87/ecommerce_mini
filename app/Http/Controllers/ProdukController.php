<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%')
                ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
        }
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        $produk = $query->latest()->get();
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'foto'        => 'nullable|array', // Pastikan divalidasi sebagai array
            'foto.*'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('_token', 'foto');

        // MULTI UPLOAD
        if ($request->hasFile('foto')) {
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('produk_foto', 'public');
            }
            $data['foto'] = json_encode($fotoPaths);
        }

        Produk::create($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk,' . $id,
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'foto'        => 'nullable|array',
            'foto.*'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('_token', '_method', 'foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama fisik
            foreach ($produk->foto_array as $oldFoto) {
                Storage::disk('public')->delete($oldFoto);
            }
            // Simpan foto baru
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('produk_foto', 'public');
            }
            $data['foto'] = json_encode($fotoPaths);
        }

        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        foreach ($produk->foto_array as $oldFoto) {
            Storage::disk('public')->delete($oldFoto);
        }
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
