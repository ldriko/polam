<?php

namespace App\Http\Controllers\Website\SuratRekomendasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Guide;

class BeasiswaController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[9])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[9])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-rekomendasi.beasiswa.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'ipk' => ['required', 'numeric', 'min:0', 'max:4', 'decimal:0,2'],
            'scholarship_provider' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1000'],
        ]);

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[9],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-rekomendasi.beasiswa.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-rekomendasi.beasiswa.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-rekomendasi.beasiswa.index', compact('submission'))->render();

        // return $file;
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
