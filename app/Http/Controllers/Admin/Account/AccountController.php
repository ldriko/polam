<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeePosition;
use App\Models\Department;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    function index(Request $request) {
        $accounts = Employee::orderBy('employee_position_id', 'asc')->paginate('10');
        return view('admin.account.index', compact('accounts'));
    }

    function create(Request $request) {
        $positions = EmployeePosition::orderBy('level', 'asc')->get();
        $departments = Department::all();
        return view('admin.account.create', compact('positions', 'departments'));
    }

    function store(Request $request) {
        $request->validate([
            'employee_position_id' => ['required', 'integer', 'exists:employee_positions,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', 'unique:employees,email'],
            'registration_type' => ['required', 'string', 'max:10'],
            'registration_number' => ['required', 'string', 'max:50'],
            'rank' => ['required', 'string', 'max:50'],
            'class' => ['required', 'string', 'max:50'],
            'password' => ['required', Password::min(6)->mixedCase()->letters()->numbers()->symbols()],
            'signature' => ['nullable', 'image', 'max:2048'],
        ]);

        // proses upload tanda tangan kalau ada
        $path = null;
        if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
            $path = $request->signature->store('signature');
            if (!$path) {
                return redirect()->route('admin.account.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload tanda tangan',
                ]);
            }
        }

        // insert data ke DB
        if (!Employee::create($request->except('signature', 'password') + ['signature' => $path, 'password' => Hash::make($request->password)])) {
            return redirect()->route('admin.account.index')->with([
                'status' => 'error',
                'message' => 'Gagal menambahkan akun admin',
            ]);
        }

        return redirect()->route('admin.account.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menambahkan akun admin',
        ]);
    }

    function edit(Request $request, Employee $account) {
        $positions = EmployeePosition::orderBy('level', 'asc')->get();
        $departments = Department::all();
        return view('admin.account.edit', compact('account', 'positions', 'departments'));
    }

    function update(Request $request, Employee $account) {
        $request->validate([
            'employee_position_id' => ['required', 'integer', 'exists:employee_positions,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', Rule::unique('employees', 'email')->ignore($account->id)],
            'registration_type' => ['required', 'string', 'max:10'],
            'registration_number' => ['required', 'string', 'max:50'],
            'rank' => ['required', 'string', 'max:50'],
            'class' => ['required', 'string', 'max:50'],
            'password' => ['nullable', Password::min(6)->mixedCase()->letters()->numbers()->symbols()],
            'signature' => ['nullable', 'image', 'max:2048'],
        ]);

        // prepare variable data tambahan
        $additional = [];

        // proses upload tanda tangan kalau ada
        if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
            $additional['signature'] = $request->signature->store('signature');
            if (!$additional['signature']) {
                return redirect()->route('admin.account.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload tanda tangan',
                ]);
            }

            // cek apakah ada tanda tangan yg lama
            if ($account->signature && Storage::exists($account->signature)) {
                // hapus tanda tangan yg lama
                if (!Storage::delete($account->signature)) {
                    return redirect()->route('admin.account.index')->with([
                        'status' => 'error',
                        'message' => 'Gagal hapus tanda tangan lama',
                    ]);
                }
            }
        }

        // cek apakah ada perubahan password
        if ($request->has('password') && $request->password) {
            $additional['password'] = Hash::make($request->password);
        }

        // insert data ke DB
        if (!$account->update($request->except('signature', 'password') + $additional)) {
            return redirect()->route('admin.account.index')->with([
                'status' => 'error',
                'message' => 'Gagal mengubah akun admin',
            ]);
        }

        return redirect()->route('admin.account.index')->with([
            'status' => 'success',
            'message' => 'Berhasil mengubah akun admin',
        ]);
    }

    function destroy(Employee $account) {
        // cek apakah ada tanda tangan yg lama
        if ($account->signature && Storage::exists($account->signature)) {
            // hapus file yg lama
            if (!Storage::delete($account->signature)) {
                return redirect()->route('admin.account.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal hapus tanda tangan lama',
                ]);
            }
        }

        // hapus data dari DB
        if (!$account->delete()) {
            return redirect()->route('admin.account.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus akun admin',
            ]);
        }

        return redirect()->route('admin.account.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menghapus akun admin',
        ]);
    }
}
