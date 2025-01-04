<?php

namespace App\Http\Controllers\Admin\Guide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use App\Models\Submission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class GuideController extends Controller
{
    function index(Request $request) {
        $guides = Guide::orderBy('type')->paginate(10);
        return view('admin.guide.index', compact('guides'));
    }

    function create(Request $request) {
        $types = Submission::TYPES;
        return view('admin.guide.create', compact('types'));
    }

    function edit(Request $request, Guide $guide) {
        $types = Submission::TYPES;
        return view('admin.guide.edit', compact('types', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'type' => ['required', 'string', Rule::in(Submission::TYPES)],
            'guide' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // ambil atau buat baru panduan sesuai tipe
        $guide = Guide::firstOrNew([
            'type' => $request->type,
        ]);

        // upload pdf yang baru dulu
        if ($request->file('guide')->isValid()) {
            $path = $request->guide->store('guide');
            if (!$path) {
                return redirect()->route('admin.guide.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload berkas panduan',
                ]);
            }
        }

        // cek apakah ada pdf yg lama
        if ($guide->file && Storage::exists($guide->file)) {
            // hapus file yg lama
            if (!Storage::delete($guide->file)) {
                return redirect()->route('admin.guide.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal hapus berkas panduan lama',
                ]);
            }
        }

        // inject file yang baru
        $guide->file = $path;

        // save / update data ke DB
        if (!$guide->save()) {
            return redirect()->route('admin.guide.index')->with([
                'status' => 'error',
                'message' => 'Gagal menyimpan panduan',
            ]);
        }

        return redirect()->route('admin.guide.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menyimpan panduan',
        ]);
    }

    function update(Request $request, Guide $guide) {
        $request->validate([
            'guide' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // upload pdf yang baru dulu
        if ($request->file('guide')->isValid()) {
            $path = $request->guide->store('guide');
            if (!$path) {
                return redirect()->route('admin.guide.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload berkas panduan',
                ]);
            }
        }

        // cek apakah ada pdf yg lama
        if ($guide->file && Storage::exists($guide->file)) {
            // hapus file yg lama
            if (!Storage::delete($guide->file)) {
                return redirect()->route('admin.guide.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal hapus berkas panduan lama',
                ]);
            }
        }

        // update data ke DB
        if (!$guide->update(['file' => $path])) {
            return redirect()->route('admin.guide.index')->with([
                'status' => 'error',
                'message' => 'Gagal menyimpan panduan',
            ]);
        }

        return redirect()->route('admin.guide.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menyimpan panduan',
        ]);
    }

    function destroy(Request $request, Guide $guide) {
        // cek apakah ada pdf yg lama
        if ($guide->file && Storage::exists($guide->file)) {
            // hapus file yg lama
            if (!Storage::delete($guide->file)) {
                return redirect()->route('admin.guide.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal hapus berkas panduan lama',
                ]);
            }
        }

        // hapus data dari DB
        if (!$guide->delete()) {
            return redirect()->route('admin.guide.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus panduan',
            ]);
        }

        return redirect()->route('admin.guide.index')->with([
            'status' => 'success',
            'message' => 'Berhasil menghapus panduan',
        ]);
    }
}
