<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isSuper = in_array(strtolower($user->role), ['super admin', 'superadmin', 'super_admin']);
        $scope = $request->query('scope');

        $query = Produk::query();

        if (!$isSuper || $scope == 'mine') {
            $query->where('user_id', $user->id);
        } else {
            $query->with('user');
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $produk = $query->latest()->get();
        return view('admin.produk.index', compact('produk', 'isSuper', 'scope'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    // ==========================================
    // SIMPAN PRODUK (DIJAMIN MASUK 100%)
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'deskripsi'   => 'required|string', // Wajib ada
            'foto'        => 'nullable|array',
            'foto.*'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Kita masukkan satu-satu secara manual agar kebal dari blokir Laravel
            $produk = new Produk();
            $produk->user_id = Auth::id();
            $produk->kode_produk = $request->kode_produk;
            $produk->nama_produk = $request->nama_produk;
            $produk->kategori = $request->kategori;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->deskripsi = $request->deskripsi; // PASTI MASUK

            if ($request->hasFile('foto')) {
                $fotoPaths = [];
                foreach ($request->file('foto') as $file) {
                    $fotoPaths[] = $file->store('produk_foto', 'public');
                }
                // Sesuaikan 'foto' dengan nama kolom db Anda (misal 'foto_array')
                $produk->foto = json_encode($fotoPaths);
            }

            $produk->save(); // Eksekusi simpan

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        $user = Auth::user();
        $isSuper = in_array(strtolower($user->role), ['super admin', 'superadmin', 'super_admin']);
        if (!$isSuper && $produk->user_id != $user->id) {
            abort(403, 'Akses Ditolak. Ini bukan produk milik toko Anda.');
        }

        return view('admin.produk.edit', compact('produk'));
    }

    // ==========================================
    // UPDATE PRODUK (DIJAMIN MASUK 100%)
    // ==========================================
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $user = Auth::user();
        $isSuper = in_array(strtolower($user->role), ['super admin', 'superadmin', 'super_admin']);
        if (!$isSuper && $produk->user_id != $user->id) {
            abort(403, 'Akses Ditolak. Ini bukan produk milik toko Anda.');
        }

        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk,' . $id,
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'deskripsi'   => 'required|string', // Wajib ada
            'foto'        => 'nullable|array',
            'foto.*'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Memasukkan update satu-satu secara manual
            $produk->kode_produk = $request->kode_produk;
            $produk->nama_produk = $request->nama_produk;
            $produk->kategori = $request->kategori;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->deskripsi = $request->deskripsi; // UPDATE PASTI MASUK

            if ($request->hasFile('foto')) {
                $kolomFoto = $produk->foto ?? $produk->foto_array;
                if (is_string($kolomFoto)) {
                    $fotos = json_decode($kolomFoto, true);
                    if (is_array($fotos)) {
                        foreach ($fotos as $oldFoto) {
                            Storage::disk('public')->delete($oldFoto);
                        }
                    }
                }

                $fotoPaths = [];
                foreach ($request->file('foto') as $file) {
                    $fotoPaths[] = $file->store('produk_foto', 'public');
                }
                $produk->foto = json_encode($fotoPaths);
            }

            $produk->save(); // Eksekusi update

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $user = Auth::user();
        $isSuper = in_array(strtolower($user->role), ['super admin', 'superadmin', 'super_admin']);
        if (!$isSuper && $produk->user_id != $user->id) {
            abort(403, 'Akses Ditolak. Ini bukan produk milik toko Anda.');
        }

        $kolomFoto = $produk->foto ?? $produk->foto_array;
        if (is_string($kolomFoto)) {
            $fotos = json_decode($kolomFoto, true);
            if (is_array($fotos)) {
                foreach ($fotos as $oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
