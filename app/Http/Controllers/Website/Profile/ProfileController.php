<?php

namespace App\Http\Controllers\Website\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    function index() {
        $departments = Department::all();
        return view('website.profile.index', compact('departments'));
    }

    function update(Request $request) {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string', 'max:255'],
        ];

        $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.string' => 'Format nama lengkap tidak valid',
            'name.max' => 'Nama lengkap maksimal 255 karakter',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_place.string' => 'Format tempat lahir tidak valid', 
            'birth_place.max' => 'Tempat lahir maksimal 255 karakter',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'birth_date.date' => 'Format tanggal lahir tidak valid',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Format alamat tidak valid',
            'address.max' => 'Alamat maksimal 255 karakter'
        ]);

        $request->replace($request->only(array_keys($rules)));
        
        // insert data ke DB
        if (!$user->update($request->all())) {
            return redirect()->route('profile.index')->with([
                'status' => 'error',
                'message' => 'Gagal mengubah profil',
            ]);
        }

        return redirect()->route('profile.index')->with([
            'status' => 'success',
            'message' => 'Berhasil mengubah profil',
        ]);
    }
}
