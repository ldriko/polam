<?php

namespace App\Http\Controllers\Website\ChangePassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    function index() {
        return view('website.change-password.index');
    }

    function update(Request $request) {
        // ambil data mahasiswa yg login saat ini
        $user = Auth::user();

        // validasi input
        $request->validate([
            'old_password' => ['required', 'current_password:web'],
            'new_password' => ['required', Password::min(6), 'confirmed:new_password'],
        ], [
            'old_password.required' => 'Password lama wajib diisi',
            'old_password.current_password' => 'Password lama tidak sesuai',
            'new_password.required' => 'Password baru wajib diisi', 
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai'
        ]);

        // ubah password di DB
        if (!$user->update(['password' => Hash::make($request->new_password)])) {
            return redirect()->route('profile.change-password.index')->with([
                'status' => 'error',
                'message' => 'Gagal mengganti password',
            ]);
        }

        // proses logout
        Auth::logout();

        // jika gagal logout redirect ke halaman asli + pesan
        if (Auth::check()) {
            return redirect()->route('profile.change-password.index')->with([
                'status' => 'error',
                'message' => 'Logout Gagal',
            ]);
        }

        // redirect ke halaman login + pesan
        return redirect()->route('login')->with([
            'status' => 'success',
            'message' => 'Berhasil mengganti password',
        ]);
    }
}
