<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;

class AdminController extends Controller
{
    // 1. Halaman Dashboard Admin (Rekap Data)
    public function dashboard()
    {
        // Hitung total pendapatan (hanya pesanan yang sudah dibayar/dikirim/selesai)
        $totalPendapatan = Pesanan::whereIn('status', ['Sudah Dibayar', 'Dikirim', 'Selesai'])->sum('total_bayar');
        $totalPesanan = Pesanan::count();

        // Hitung status penting
        $pesananBaru = Pesanan::where('status', 'Belum Dibayar')->count();
        $siapDikirim = Pesanan::where('status', 'Sudah Dibayar')->count();

        // Ambil 5 pesanan terbaru untuk preview
        $pesananTerbaru = Pesanan::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalPendapatan', 'totalPesanan', 'pesananBaru', 'siapDikirim', 'pesananTerbaru'));
    }

    // 2. Halaman Kelola Pesanan
    public function pesananIndex(Request $request)
    {
        $query = Pesanan::with(['user', 'details.produk'])->latest();

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pesanan = $query->paginate(10); // Menampilkan 10 data per halaman
        return view('admin.pesanan.index', compact('pesanan'));
    }

    // 3. Proses Update Status Pesanan (Kirim, Selesai, dll)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan ' . $pesanan->kode_pesanan . ' berhasil diubah menjadi ' . $request->status . '!');
    }
}
