<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Produk; // Pastikan Model Produk dipanggil
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ==========================================
    // 1. Halaman Dashboard Admin (Rekap Data)
    // ==========================================
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $isSuper = in_array(strtolower($user->role), ['super admin', 'superadmin', 'super_admin']);
        $scope = $request->query('scope');

        $queryPesanan = Pesanan::query();
        $queryProduk = Produk::query();

        if (!$isSuper || $scope == 'mine') {
            // =======================================
            // KHUSUS ADMIN (ATAU SUPER ADMIN MODE TOKO SAYA)
            // =======================================
            $totalProduk = $queryProduk->where('user_id', $user->id)->count();

            // Hitung hanya pesanan yang mengandung produk milik Admin ini
            $totalPesanan = Pesanan::whereHas('details.produk', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            $pesananBaru = Pesanan::where('status', 'Belum Dibayar')
                ->whereHas('details.produk', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->count();

            $siapDikirim = Pesanan::where('status', 'Sudah Dibayar')
                ->whereHas('details.produk', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->count();

            // Ambil 5 pesanan terbaru (yang ada produk admin ini)
            $pesananTerbaru = Pesanan::with('user')
                ->whereHas('details.produk', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->latest()->take(5)->get();

            // Hitung pendapatan khusus milik Admin ini
            $pesananSelesai = Pesanan::with('details.produk')
                ->whereIn('status', ['Sudah Dibayar', 'Dikirim', 'Selesai'])
                ->whereHas('details.produk', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->get();

            $totalPendapatan = 0;
            foreach ($pesananSelesai as $pesanan) {
                foreach ($pesanan->details as $detail) {
                    if ($detail->produk && $detail->produk->user_id == $user->id) {
                        $totalPendapatan += $detail->subtotal;
                    }
                }
            }
        } else {
            // =======================================
            // KHUSUS SUPER ADMIN MODE GLOBAL
            // =======================================
            $totalProduk = $queryProduk->count();
            $totalPendapatan = Pesanan::whereIn('status', ['Sudah Dibayar', 'Dikirim', 'Selesai'])->sum('total_bayar');
            $totalPesanan = Pesanan::count();

            $pesananBaru = Pesanan::where('status', 'Belum Dibayar')->count();
            $siapDikirim = Pesanan::where('status', 'Sudah Dibayar')->count();
            $pesananTerbaru = Pesanan::with('user')->latest()->take(5)->get();
        }

        // Semua variabel dikirim ke Blade dengan aman
        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalPesanan',
            'pesananBaru',
            'siapDikirim',
            'pesananTerbaru',
            'totalProduk',
            'isSuper',
            'scope'
        ));
    }

    // ==========================================
    // 2. Halaman Kelola Pesanan
    // ==========================================
    public function pesananIndex(Request $request)
    {
        $user = Auth::user();
        $isSuper = in_array(strtolower($user->role), ['super admin', 'superadmin', 'super_admin']);
        $scope = $request->query('scope');

        $query = Pesanan::with(['user', 'details.produk'])->latest();

        // Isolasi data: Tampilkan HANYA pesanan yang mengandung produk milik Admin ini
        if (!$isSuper || $scope == 'mine') {
            $query->whereHas('details.produk', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // Filter Status (Sesuai kode asli Anda)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Menggunakan Paginate (10) sesuai kode asli Anda
        $pesanan = $query->paginate(10);

        return view('admin.pesanan.index', compact('pesanan', 'isSuper', 'scope'));
    }

    // ==========================================
    // 3. Proses Update Status Pesanan
    // ==========================================
    public function updateStatus(Request $request, $id)
    {
        // Tambahan validasi untuk no_resi jika admin sedang mengubah status jadi "Dikirim"
        $request->validate([
            'status' => 'required|string',
            'no_resi' => 'nullable|string'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;

        // Simpan no_resi jika ada
        if ($request->has('no_resi') && $request->no_resi != '') {
            $pesanan->no_resi = $request->no_resi;
        }

        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan ' . $pesanan->kode_pesanan . ' berhasil diubah menjadi ' . $request->status . '!');
    }
}
