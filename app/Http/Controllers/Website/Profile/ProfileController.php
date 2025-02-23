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
            'registration_number' => ['required', 'numeric', 'digits:11'],
            'department_id' => ['required', 'exists:departments,id'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string', 'max:255'],
        ];

        $request->validate($rules);
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
