<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // ==========================================
    // MENAMPILKAN HALAMAN DAFTAR PESANAN
    // ==========================================
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
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Gunakan save manual anti-blokir
        $pesanan->status = 'Selesai';
        $pesanan->save();

        return redirect()->back()->with('success', 'Hore! Pesanan telah selesai. Jangan lupa beri bintang 5 dan penilaian produk ya!');
    }

    // ==========================================
    // FUNGSI UNTUK MENYIMPAN REVIEW / ULASAN (ANTI-ERROR)
    // ==========================================
    public function submitReview(Request $request, $id)
    {
        // Validasi input rating dan foto
        $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'komentar'    => 'required|string',
            'foto_review' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Max 2MB
        ]);

        try {
            $pesanan = Pesanan::with('details')->where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Proses simpan foto jika user mengunggahnya
            $fotoPath = null;
            if ($request->hasFile('foto_review')) {
                $fotoPath = $request->file('foto_review')->store('reviews', 'public');
            }

            // Simpan ulasan untuk setiap produk di pesanan tersebut
            foreach ($pesanan->details as $detail) {
                // Cek agar tidak review dobel
                $cekReview = Ulasan::where('pesanan_id', $pesanan->id)
                    ->where('produk_id', $detail->produk_id)
                    ->first();

                if (!$cekReview) {
                    // SIMPAN MANUAL SATU PER SATU (DIJAMIN MASUK 100%)
                    $ulasan = new Ulasan();
                    $ulasan->pesanan_id  = $pesanan->id;
                    $ulasan->produk_id   = $detail->produk_id;
                    $ulasan->user_id     = Auth::id();
                    $ulasan->rating      = $request->rating;
                    $ulasan->komentar    = $request->komentar;
                    $ulasan->foto_review = $fotoPath;
                    $ulasan->save(); // Eksekusi simpan ke database
                }
            }

            // PASTIKAN STATUS PESANAN MENJADI "SELESAI" JIKA SEBELUMNYA BELUM
            if ($pesanan->status !== 'Selesai') {
                $pesanan->status = 'Selesai';
                $pesanan->save();
            }

            return redirect()->back()->with('success', 'Terima kasih banyak! Penilaian Anda berhasil disimpan dan akan sangat berguna bagi pembeli lainnya.');
        } catch (\Exception $e) {
            // JIKA GAGAL, sistem akan menampilkan notifikasi warna merah berisi sumber error
            return redirect()->back()->with('error', 'Gagal mengirim ulasan: ' . $e->getMessage());
        }
    }
}
