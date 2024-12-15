<?php

namespace App\Http\Controllers\Website\SuratRekomendasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MbkmController extends Controller
{
    function index() {
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[10])->with('user')->orderBy('created_at', 'desc')->get();
        return view('website.surat-rekomendasi.mbkm.index', compact('data'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'ipk' => ['required', 'numeric'],
            'program_name' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1000'],
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
