<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index() {
        return view('admin.auth.login');
    }

    function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email', 'exists:employees,email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('employee')->attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.auth.login')->with([
            'status' => 'error',
            'message' => 'Login Gagal',
        ]);
    }

    function logout() {
        if (Auth::guard('employee')->logout()) {
            return redirect()->route('admin.auth.login');
        }

        return redirect()->route('admin.dashboard')->with([
            'status' => 'error',
            'message' => 'Logout Gagal',
        ]);
    }
}
