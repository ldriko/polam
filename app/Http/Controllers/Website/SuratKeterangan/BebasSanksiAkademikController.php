<?php

namespace App\Http\Controllers\Website\SuratKeterangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Guide;

class BebasSanksiAkademikController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[4])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[4])->with('user')->orderBy('created_at', 'desc')->paginate();
        return view('website.surat-keterangan.bebas-sanksi-akademik.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'birth_place' => ['required', 'string'],
            'birth_date' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[4],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-keterangan.bebas-sanksi-akademik.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-keterangan.bebas-sanksi-akademik.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-keterangan.bebas-sanksi-akademik.index', compact('submission'))->render();
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
