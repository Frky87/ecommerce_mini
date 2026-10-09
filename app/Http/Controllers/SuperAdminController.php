<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        // AMBIL DATA PENDING: Ambil yang pending DAN BUKAN admin agar tidak dobel
        $pendingRequests = User::where('pengajuan_toko', 'pending')
            ->whereNot('role', 'admin')
            ->whereNot('role', 'super admin')
            ->whereNot('role', 'superadmin')
            ->whereNot('role', 'super_admin')
            ->latest()->get();

        // PERBAIKAN: Hanya ambil yang rolenya murni 'admin' (Super Admin tidak ikut tampil di daftar)
        $admins = User::where('role', 'admin')->latest()->get();

        return view('admin.kelola_admin.index', compact('pendingRequests', 'admins'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        // MENGHINDARI ERROR FILLABLE LARAVEL
        $user->role = 'admin';
        $user->pengajuan_toko = 'diterima';
        $user->save(); // Simpan paksa

        return back()->with('success', 'Pengajuan disetujui! ' . $user->nama_lengkap . ' kini resmi menjadi Admin.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);

        // MENGHINDARI ERROR FILLABLE LARAVEL
        $user->pengajuan_toko = 'ditolak';
        $user->save(); // Simpan paksa

        return back()->with('error', 'Pengajuan Buka Toko dari ' . $user->nama_lengkap . ' telah ditolak.');
    }
}
