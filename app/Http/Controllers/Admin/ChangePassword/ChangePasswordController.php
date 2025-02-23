<?php

namespace App\Http\Controllers\Admin\ChangePassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    function index(Request $request) {
        $employee = Auth::guard('employee')->user();
        return view('admin.change-password.index', compact('employee'));
    }

    function update(Request $request) {
        // ambil data pegawai yg login saat ini
        $employee = Auth::guard('employee')->user();

        // validasi input
        $request->validate([
            'old_password' => ['required', 'current_password:employee'],
            'new_password' => ['required', Password::min(6)->mixedCase()->letters()->numbers()->symbols(), 'confirmed:new_password'],
        ]);

        // ubah password di DB
        if (!$employee->update(['password' => Hash::make($request->new_password)])) {
            return redirect()->route('admin.change-password.index')->with([
                'status' => 'error',
                'message' => 'Gagal mengganti password',
            ]);
        }

        // proses logout
        Auth::guard('employee')->logout();

        // jika gagal logout redirect ke halaman asli + pesan
        if (Auth::guard('employee')->check()) {
            return redirect()->route('admin.change-password.index')->with([
                'status' => 'error',
                'message' => 'Logout Gagal',
            ]);
        }

        // redirect ke halaman login + pesan
        return redirect()->route('admin.auth.login')->with([
            'status' => 'success',
            'message' => 'Berhasil mengganti password',
        ]);
    }
}
