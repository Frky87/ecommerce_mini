<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $cartItems = Keranjang::with('produk')->where('user_id', Auth::id())->latest()->get();
        return view('katalog.cart', compact('cartItems'));
    }

    public function store(Request $request)
    {
        // BLOKIR ADMIN DARI MEMASUKKAN BARANG KE KERANJANG
        if (Auth::check() && in_array(strtolower(Auth::user()->role), ['admin', 'super admin', 'superadmin', 'super_admin'])) {
            return redirect()->back()->with('error', 'Akses Ditolak! Admin tidak diperbolehkan berbelanja.');
        }

        $request->validate([
            'produk_id' => 'required',
            'kuantitas' => 'required|numeric|min:1'
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($request->kuantitas > $produk->stok) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = Keranjang::where('user_id', Auth::id())->where('produk_id', $request->produk_id)->first();

        if ($cart) {
            if (($cart->kuantitas + $request->kuantitas) > $produk->stok) {
                return redirect()->back()->with('error', 'Total kuantitas melebihi stok yang tersedia!');
            }
            $cart->update(['kuantitas' => $cart->kuantitas + $request->kuantitas]);
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'kuantitas' => $request->kuantitas
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['kuantitas' => 'required|numeric|min:1']);
        $cart = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->kuantitas > $cart->produk->stok) {
            return redirect()->back()->with('error', 'Kuantitas melebihi stok yang tersedia!');
        }

        $cart->update(['kuantitas' => $request->kuantitas]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function destroyMultiple(Request $request)
    {
        if (!$request->cart_ids) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih untuk dihapus.');
        }

        Keranjang::whereIn('id', $request->cart_ids)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Produk terpilih berhasil dihapus dari keranjang.');
    }
}
