<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
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
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'kuantitas' => 'required|integer|min:1'
        ]);

        $cart = Keranjang::where('user_id', Auth::id())->where('produk_id', $request->produk_id)->first();

        if ($cart) {
            $cart->kuantitas += $request->kuantitas;
            $cart->save();
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'kuantitas' => $request->kuantitas
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // FUNGSI BARU: Untuk Mengupdate Kuantitas (+ / -)
    public function update(Request $request, $id)
    {
        $request->validate([
            'kuantitas' => 'required|integer|min:1'
        ]);

        $cart = Keranjang::where('id', $id)->where('user_id', Auth::id())->first();
        if ($cart) {
            // Pastikan kuantitas tidak melebihi stok yang ada
            $stokTersedia = $cart->produk->stok;
            $qtyBaru = $request->kuantitas > $stokTersedia ? $stokTersedia : $request->kuantitas;

            $cart->update(['kuantitas' => $qtyBaru]);
        }

        return redirect()->back(); // Reload halaman tanpa pesan berlebihan
    }

    public function destroy($id)
    {
        Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
