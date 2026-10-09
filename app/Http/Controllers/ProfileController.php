<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // ==========================================
    // MEMPROSES UPDATE DATA DIRI (FORM 1)
    // ==========================================
    public function update(Request $request)
    {
        $user = Auth::user();
        $isAdmin = in_array(strtolower($user->role), ['admin', 'super admin', 'superadmin', 'super_admin']);

        $rules = [
            'nama_lengkap'  => 'required|string|max:255',
            'username'      => 'required|string|email|max:255|unique:user,username,' . $user->id,
            'no_telp'       => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat'        => 'nullable|string',
            'deskripsi'     => 'nullable|string',
        ];

        // Jika dia Admin/SuperAdmin, boleh update Nama Toko
        if ($isAdmin) {
            $rules['nama_toko'] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->no_telp = $request->no_telp;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->deskripsi = $request->deskripsi;

        // Simpan nama toko hanya jika dia admin
        if ($isAdmin && $request->has('nama_toko')) {
            $user->nama_toko = $request->nama_toko;
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    // ==========================================
    // MEMPROSES GANTI PASSWORD (FORM 2)
    // ==========================================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    // ==========================================
    // MEMPROSES PENGAJUAN BUKA TOKO (FORM 3)
    // ==========================================
    public function ajukanToko(Request $request)
    {
        // Wajib mengisi Nama Toko dan Deskripsi saat mengajukan
        $request->validate([
            'nama_toko' => 'required|string|max:255|unique:user,nama_toko,' . Auth::id(),
            'deskripsi' => 'required|string',
        ], [
            'nama_toko.required' => 'Nama Toko wajib diisi untuk membuka toko.',
            'nama_toko.unique' => 'Nama Toko ini sudah digunakan oleh orang lain.',
            'deskripsi.required' => 'Deskripsi Toko wajib diisi untuk membuka toko.'
        ]);

        $user = Auth::user();
        $user->nama_toko = $request->nama_toko;
        $user->deskripsi = $request->deskripsi;
        $user->pengajuan_toko = 'pending';
        $user->save();

        return back()->with('success', 'Pengajuan Buka Toko berhasil dikirim! Menunggu persetujuan Super Admin.');
    }
}
