<?php

namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use App\Models\Department;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('website.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class, 'ends_with:@student.upnjatim.ac.id'],
            'registration_number' => ['required', 'numeric', 'digits:11'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'email.ends_with' => 'Email harus menggunakan domain @student.upnjatim.ac.id',
            'registration_number.required' => 'NPM wajib diisi',
            'registration_number.numeric' => 'NPM harus berupa angka',
            'registration_number.digits' => 'NPM harus 11 digit',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        // Validate that registration number matches email prefix
        $emailPrefix = explode('@', $request->email)[0];
        if ($emailPrefix !== $request->registration_number) {
            return back()->withErrors([
                'registration_number' => 'NPM harus sama dengan bagian email sebelum @'
            ])->withInput();
        }

        // Get department ID from 5th digit of registration number
        $departmentId = substr($request->registration_number, 4, 1);
        $department = Department::find($departmentId);

        if (!$department) {
            return back()->withErrors([
                'registration_number' => 'Kode Jurusan dari NPM tidak valid'
            ])->withInput();
        }

        $user = User::create([
            'department_id' => $departmentId,
            'name' => $request->name,
            'email' => $request->email,
            'registration_number' => $request->registration_number,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
