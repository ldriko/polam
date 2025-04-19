<?php

namespace App\Http\Controllers\Website\SuratRekomendasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Guide;

class MbkmController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[10])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[10])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-rekomendasi.mbkm.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'ipk' => ['required', 'numeric', 'min:0', 'max:4', 'decimal:0,2'],
            'program_name' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 10)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.string' => 'Format nama lengkap tidak valid',
            'registration_number.required' => 'NPM wajib diisi',
            'registration_number.string' => 'Format NPM tidak valid',
            'department.required' => 'Program studi wajib diisi',
            'department.string' => 'Format program studi tidak valid',
            'semester.required' => 'Semester wajib diisi',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.between' => 'Semester harus antara 1-14',
            'ipk.required' => 'IPK wajib diisi',
            'ipk.numeric' => 'IPK harus berupa angka',
            'ipk.min' => 'IPK minimal 0',
            'ipk.max' => 'IPK maksimal 4',
            'ipk.decimal' => 'IPK berkoma, maksimal 2 digit koma',
            'program_name.required' => 'Nama program MBKM wajib diisi',
            'program_name.string' => 'Format nama program MBKM tidak valid',
            'year.required' => 'Tahun wajib diisi',
            'year.integer' => 'Tahun harus berupa angka',
            'year.min' => 'Tahun minimal tahun sekarang',
            'year.max' => 'Tahun maksimal 10 tahun mendatang',
        ]);

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[10],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-rekomendasi.mbkm.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-rekomendasi.mbkm.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // prepare tahun ajaran
        $createdAt = Carbon::parse($submission->created_at);
        $yearStart = $createdAt->year;
        $yearEnd = $createdAt->year;

        if ($createdAt->month <= 7) { // genap, februari sampai juli atau ganjil tahun lalu
            $yearStart -= 1;
        } else {
            $yearEnd += 1;
        }

        // gabung tahun ajarannya
        $academicYear = $yearStart . '-' . $yearEnd;

        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-rekomendasi.mbkm.index', compact('submission', 'academicYear'))->render();

        // return $file;
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
