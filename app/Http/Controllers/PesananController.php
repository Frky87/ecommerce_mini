<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // Menampilkan halaman Daftar Pesanan User (Dengan Fitur Filter)
    public function index(Request $request)
    {
        // Siapkan antrean pencarian data pesanan
        $query = Pesanan::with('details.produk')->where('user_id', Auth::id());

        // Jika user mengeklik tab filter (status), maka saring datanya
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Ambil data terbaru
        $pesanan = $query->latest()->get();

        return view('katalog.pesanan', compact('pesanan'));
    }

    // ==========================================
    // FUNGSI UNTUK MENEKAN TOMBOL "PESANAN DITERIMA"
    // ==========================================
    public function selesai($id)
    {
        // Pastikan hanya pemilik pesanan yang bisa klik selesai
        $pesanan = \App\Models\Pesanan::where('id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        // Ubah status jadi Selesai
        $pesanan->update(['status' => 'Selesai']);

        return redirect()->back()->with('success', 'Hore! Pesanan telah selesai. Jangan lupa beri bintang 5 dan penilaian produk ya!');
    }

    // ==========================================
    // FUNGSI UNTUK MENYIMPAN REVIEW / ULASAN
    // ==========================================
    public function submitReview(\Illuminate\Http\Request $request, $id)
    {
        // Validasi input rating dan foto
        $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'komentar'    => 'required|string',
            'foto_review' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Max 2MB
        ]);

        $pesanan = \App\Models\Pesanan::with('details')->where('id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        // Proses simpan foto jika user mengunggahnya
        $fotoPath = null;
        if ($request->hasFile('foto_review')) {
            $fotoPath = $request->file('foto_review')->store('reviews', 'public');
        }

        // Karena dalam 1 pesanan bisa ada banyak produk, 
        // kita simpan ulasannya untuk setiap produk di pesanan tersebut.
        foreach ($pesanan->details as $detail) {
            // Cek agar tidak review dobel
            $cekReview = \App\Models\Ulasan::where('pesanan_id', $pesanan->id)
                ->where('produk_id', $detail->produk_id)
                ->first();

            if (!$cekReview) {
                \App\Models\Ulasan::create([
                    'pesanan_id'  => $pesanan->id,
                    'produk_id'   => $detail->produk_id,
                    'user_id'     => \Illuminate\Support\Facades\Auth::id(),
                    'rating'      => $request->rating,
                    'komentar'    => $request->komentar,
                    'foto_review' => $fotoPath
                ]);
            }
        }

        return redirect()->back()->with('success', 'Terima kasih banyak! Penilaian Anda berhasil disimpan dan akan sangat berguna bagi pembeli lainnya.');
    }
}
