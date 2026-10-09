<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function prepareCart(Request $request)
    {
        // BLOKIR ADMIN DARI CHECKOUT
        if (Auth::check() && in_array(strtolower(Auth::user()->role), ['admin', 'super admin', 'superadmin', 'super_admin'])) {
            return redirect()->back()->with('error', 'Akses Ditolak! Admin tidak diperbolehkan berbelanja.');
        }

        if (!$request->cart_ids) return back()->with('error', 'Pilih produk dulu!');
        session(['checkout_data' => ['type' => 'cart', 'ids' => $request->cart_ids]]);
        return redirect()->route('checkout.index');
    }

    public function prepareDirect(Request $request)
    {
        // BLOKIR ADMIN DARI CHECKOUT LANGSUNG
        if (Auth::check() && in_array(strtolower(Auth::user()->role), ['admin', 'super admin', 'superadmin', 'super_admin'])) {
            return redirect()->back()->with('error', 'Akses Ditolak! Admin tidak diperbolehkan berbelanja.');
        }

        $request->validate(['produk_id' => 'required', 'kuantitas' => 'required|min:1']);
        session(['checkout_data' => ['type' => 'direct', 'produk_id' => $request->produk_id, 'kuantitas' => $request->kuantitas]]);
        return redirect()->route('checkout.index');
    }

    public function index()
    {
        $data = session('checkout_data');
        if (!$data) return redirect()->route('katalog');

        $user = Auth::user();
        $items = [];
        $totalHarga = 0;

        if ($data['type'] == 'cart') {
            $cartItems = Keranjang::with('produk')->whereIn('id', $data['ids'])->get();
            foreach ($cartItems as $c) {
                $items[] = (object)['produk' => $c->produk, 'kuantitas' => $c->kuantitas, 'cart_id' => $c->id];
                $totalHarga += $c->produk->harga * $c->kuantitas;
            }
        } else {
            $produk = Produk::findOrFail($data['produk_id']);
            $items[] = (object)['produk' => $produk, 'kuantitas' => $data['kuantitas'], 'cart_id' => null];
            $totalHarga += $produk->harga * $data['kuantitas'];
        }

        // SIMULASI ONGKIR
        $ongkir = 30000;
        if ($user && $user->alamat) {
            $almt = strtolower($user->alamat);
            if (strpos($almt, 'singosari') !== false) $ongkir = 5000;
            elseif (strpos($almt, 'malang') !== false) $ongkir = 10000;
            elseif (strpos($almt, 'surabaya') !== false || strpos($almt, 'sidoarjo') !== false) $ongkir = 20000;
            elseif (strpos($almt, 'jakarta') !== false) $ongkir = 40000;
        }

        $totalBayar = $totalHarga + $ongkir;
        return view('katalog.checkout', compact('items', 'totalHarga', 'ongkir', 'totalBayar', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'metode_pembayaran' => 'required',
            'total_harga' => 'required|numeric',
            'ongkir' => 'required|numeric',
            'total_bayar' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'kode_pesanan' => 'MKT-' . strtoupper(uniqid()),
                'alamat_pengiriman' => $request->alamat,
                'ongkir' => $request->ongkir,
                'total_harga' => $request->total_harga,
                'total_bayar' => $request->total_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'Belum Dibayar'
            ]);

            $data = session('checkout_data');

            if ($data['type'] == 'cart') {
                $cartItems = Keranjang::with('produk')->whereIn('id', $data['ids'])->get();
                foreach ($cartItems as $c) {
                    PesananDetail::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $c->produk_id,
                        'kuantitas' => $c->kuantitas,
                        'harga_satuan' => $c->produk->harga,
                        'subtotal' => $c->produk->harga * $c->kuantitas,
                    ]);
                    Produk::where('id', $c->produk_id)->decrement('stok', $c->kuantitas);
                    $c->delete();
                }
            } else {
                $produk = Produk::find($data['produk_id']);
                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $produk->id,
                    'kuantitas' => $data['kuantitas'],
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $produk->harga * $data['kuantitas'],
                ]);
                Produk::where('id', $produk->id)->decrement('stok', $data['kuantitas']);
            }

            DB::commit();
            session()->forget('checkout_data');
            return redirect()->route('checkout.payment', $pesanan->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Pesanan gagal diproses. Silakan coba lagi.');
        }
    }

    public function payment($id)
    {
        $pesanan = Pesanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('katalog.payment', compact('pesanan'));
    }

    public function confirmPayment($id)
    {
        $pesanan = Pesanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $pesanan->update(['status' => 'Sudah Dibayar']);
        return redirect()->route('katalog')->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda segera diproses.');
    }

    public function cancelPayment($id)
    {
        $pesanan = Pesanan::with('details')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($pesanan->status == 'Belum Dibayar') {
            DB::beginTransaction();
            try {
                foreach ($pesanan->details as $detail) {
                    Produk::where('id', $detail->produk_id)->increment('stok', $detail->kuantitas);
                }
                $pesanan->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('katalog')->with('error', 'Gagal membatalkan pesanan.');
            }
        }
        return redirect()->route('katalog')->with('error', 'Waktu pembayaran telah habis. Pesanan dibatalkan otomatis dan stok barang telah dikembalikan.');
    }
}
