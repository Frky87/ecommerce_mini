<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================================
    // BAGIAN LOGIN MANUAL
    // ==========================================
    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('produk.index');
            } else {
                return redirect()->route('katalog');
            }
        }

        return back()->withErrors([
            'username' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    // ==========================================
    // BAGIAN REGISTRASI MANUAL
    // ==========================================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|email|max:255|unique:user,username',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telp'      => 'required|string|max:15',
            'password'     => 'required|string|min:8|confirmed',
        ], [
            'username.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain atau login.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        $user = User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'username'      => $request->username,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp'       => $request->no_telp,
            'password'      => Hash::make($request->password),
            'role'          => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('katalog')->with('success', 'Registrasi berhasil! Selamat datang di Marketqu.');
    }

    // ==========================================
    // BAGIAN LOGIN GOOGLE
    // ==========================================
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('username', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user sudah ada, sinkronkan google_id
                $user->update([
                    'google_id' => $googleUser->getId()
                ]);
            } else {
                // Jika user belum ada (Registrasi via Google)
                $user = User::create([
                    'nama_lengkap'  => $googleUser->getName() ?? 'Pengguna Google',
                    'username'      => $googleUser->getEmail(),
                    'google_id'     => $googleUser->getId(),
                    'password'      => Hash::make(Str::random(24)), // Password acak kuat
                    // Memberikan nilai default agar database tidak error (karena wajib diisi / NOT NULL)
                    'jenis_kelamin' => 'Laki-Laki',
                    'no_telp'       => '-',
                    'role'          => 'user',
                ]);
            }

            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('produk.index');
            } else {
                return redirect()->route('katalog')->with('success', 'Berhasil login menggunakan Google!');
            }
        } catch (\Exception $e) {
            // Jika masih error, pesannya akan dimunculkan agar kita tahu sebabnya
            return redirect()->route('login')->withErrors(['username' => 'Gagal login via Google: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // BAGIAN LOGOUT
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('katalog');
    }
}
