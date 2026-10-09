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
        if (Auth::check()) {
            $role = strtolower(Auth::user()->role);

            // CEK 'super admin'
            if (in_array($role, ['admin', 'super admin', 'super_admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('katalog');
        }

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

            $role = strtolower(Auth::user()->role);

            // CEK 'super admin'
            if (in_array($role, ['admin', 'super admin', 'super_admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Super Admin/Admin!');
            } else {
                return redirect()->route('katalog')->with('success', 'Login berhasil! Selamat berbelanja.');
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
        if (Auth::check()) {
            return redirect()->route('katalog');
        }
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'username'      => 'required|string|email|max:255|unique:user,username',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telp'       => 'required|string|max:15',
            'password'      => 'required|string|min:8|confirmed',
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
                $user->update([
                    'google_id' => $googleUser->getId()
                ]);
            } else {
                $user = User::create([
                    'nama_lengkap'  => $googleUser->getName() ?? 'Pengguna Google',
                    'username'      => $googleUser->getEmail(),
                    'google_id'     => $googleUser->getId(),
                    'password'      => Hash::make(Str::random(24)),
                    'jenis_kelamin' => 'Laki-Laki',
                    'no_telp'       => '-',
                    'role'          => 'user',
                ]);
            }

            Auth::login($user);

            $role = strtolower(Auth::user()->role);

            // CEK 'super admin'
            if (in_array($role, ['admin', 'super admin', 'super_admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login Google sebagai Admin!');
            } else {
                return redirect()->route('katalog')->with('success', 'Berhasil login menggunakan Google!');
            }
        } catch (\Exception $e) {
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

        return redirect()->route('login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}
