<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika yang login adalah admin, izinkan masuk!
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika user biasa mencoba masuk ke link Admin, tendang balik ke Katalog!
        return redirect()->route('katalog')->with('error', 'Akses Ditolak! Anda bukan Admin.');
    }
}
