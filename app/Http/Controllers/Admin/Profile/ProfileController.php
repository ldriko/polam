<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\EmployeePosition;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    function index() {
        $employee = Auth::guard('employee')->user();
        $positions = EmployeePosition::orderBy('level', 'asc')->get();
        $departments = Department::all();
        return view('admin.profile.index', compact('employee', 'positions', 'departments'));
    }

    function store(Request $request) {
        $employee = Auth::guard('employee')->user();

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', Rule::unique('employees', 'email')->ignore($employee->id)],
            'registration_type' => ['required', 'string', 'max:10'],
            'registration_number' => ['required', 'string', 'max:50'],
            'rank' => ['required', 'string', 'max:50'],
            'class' => ['required', 'string', 'max:50'],
            'signature' => ['nullable', 'image', 'max:2048'],
        ];
        $request->validate($rules);
        $request->replace($request->only(array_keys($rules)));

        // prepare variable data tambahan
        $additional = [];

        // proses upload tanda tangan kalau ada
        if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
            $additional['signature'] = $request->signature->store('signature');
            if (!$additional['signature']) {
                return redirect()->route('admin.profile.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload tanda tangan',
                ]);
            }

            // cek apakah ada tanda tangan yg lama
            if ($employee->signature && Storage::exists($employee->signature)) {
                // hapus tanda tangan yg lama
                if (!Storage::delete($employee->signature)) {
                    return redirect()->route('admin.profile.index')->with([
                        'status' => 'error',
                        'message' => 'Gagal hapus tanda tangan lama',
                    ]);
                }
            }
        }

        // insert data ke DB
        if (!$employee->update($request->except('signature') + $additional)) {
            return redirect()->route('admin.profile.index')->with([
                'status' => 'error',
                'message' => 'Gagal mengubah akun admin',
            ]);
        }

        return redirect()->route('admin.profile.index')->with([
            'status' => 'success',
            'message' => 'Berhasil mengubah akun admin',
        ]);
    }
}
