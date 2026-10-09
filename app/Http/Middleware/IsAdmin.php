<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = strtolower(Auth::user()->role);

            if (in_array($role, ['admin', 'super admin', 'super_admin', 'superadmin'])) {
                return $next($request);
            }
        }

        // Jika user biasa mencoba masuk ke link admin, tendang ke katalog
        return redirect()->route('katalog')->with('error', 'Akses ditolak! Anda tidak memiliki izin ke halaman Admin.');
    }
}
