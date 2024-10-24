<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna login dan memiliki level admin
        if (Auth::check() && Auth::user()->level === 'admin') {
            return $next($request); // Izinkan akses jika pengguna adalah admin
        }

        // Jika tidak admin, redirect ke halaman lain dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
    }
}
