<?php

namespace App\Http\Controllers\Admin\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    function index() {
        $departments = Department::all();
        return view('admin.department.index', compact('departments'));
    }

    function create() {
        return view('admin.department.create');
    }

    function store(Request $request) {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
        $request->validate($rules);
        $request->replace($request->only(array_keys($rules)));

        // prepare variable data tambahan
        $additional = [];

        // proses upload gambar kalau ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $additional['image'] = $request->image->store('department');
            if (!$additional['image']) {
                return redirect()->route('admin.department.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload logo prodi',
                ]);
            }
        }

        // insert data ke DB
        if (!Department::create($request->except('image') + $additional)) {
            return redirect()->route('admin.department.index')->with([
                'status' => 'error',
                'message' => 'Gagal menambahkan prodi',
            ]);
        }

        return redirect()->route('admin.department.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menambahkan prodi',
        ]);
    }

    function edit(Request $request, Department $department) {
        return view('admin.department.edit', compact('department'));
    }

    function update(Request $request, Department $department) {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
        $request->validate($rules);
        $request->replace($request->only(array_keys($rules)));

        // prepare variable data tambahan
        $additional = [];

        // proses upload gambar kalau ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $additional['image'] = $request->image->store('department');
            if (!$additional['image']) {
                return redirect()->route('admin.department.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload logo prodi',
                ]);
            }

            // cek apakah ada logo yg lama
            if ($department->image && Storage::exists($department->image)) {
                // hapus logo yg lama
                if (!Storage::delete($department->image)) {
                    return redirect()->route('admin.department.index')->with([
                        'status' => 'error',
                        'message' => 'Gagal hapus logo prodi lama',
                    ]);
                }
            }
        }

        // insert data ke DB
        if (!$department->update($request->except('image') + $additional)) {
            return redirect()->route('admin.department.index')->with([
                'status' => 'error',
                'message' => 'Gagal mengubah prodi',
            ]);
        }

        return redirect()->route('admin.department.index')->with([
            'status' => 'success',
            'message' => 'Berhasil mengubah prodi',
        ]);
    }

    function destroy(Request $request, Department $department) {
        // cek apakah ada logo yg lama
        if ($department->image && Storage::exists($department->image)) {
            // hapus logo yg lama
            if (!Storage::delete($department->image)) {
                return redirect()->route('admin.department.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal hapus logo prodi lama',
                ]);
            }
        }

        // hapus data dari DB
        if (!$department->delete()) {
            return redirect()->route('admin.department.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus prodi',
            ]);
        }

        return redirect()->route('admin.department.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menghapus prodi',
        ]);
    }
}
