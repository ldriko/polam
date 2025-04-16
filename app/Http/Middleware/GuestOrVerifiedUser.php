<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GuestOrVerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // jika mahasiswa belum login, maka lanjut
        if (!Auth::guard('web')->check()) {
            return $next($request);
        }
        
        // jika mahasiswa sudah login, maka cek apakah email sudah diverifikasi
        if (Auth::guard('web')->check() && !Auth::guard('web')->user()->hasVerifiedEmail()) {
            // redirect ke halaman verifikasi email
            return redirect()->route('verification.notice');
        }
        
        // jika mahasiswa sudah login dan email sudah diverifikasi, maka lanjut
        return $next($request);
    }
}
