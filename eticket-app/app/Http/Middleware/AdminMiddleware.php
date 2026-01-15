<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login dan memiliki role 'admin'
        // Menggunakan kolom 'role' sesuai struktur database Anda
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // 2. Jika bukan admin, lempar ke dashboard utama
        // Ini mencegah user biasa terjebak di halaman login atau error 403
        return redirect()->route('dashboard')->with('error', 'Akses khusus Administrator.');
    }
}