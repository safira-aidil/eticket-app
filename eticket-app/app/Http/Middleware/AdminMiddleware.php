<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role-nya adalah 'admin'
        if (Auth::user()->role !== 'admin') {
            // Jika BUKAN admin, lempar ke dashboard user biasa
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses Admin.');
        }

        return $next($request);
    }
}