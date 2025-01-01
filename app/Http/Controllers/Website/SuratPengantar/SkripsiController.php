<?php

namespace App\Http\Controllers\Website\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Submission;

class SkripsiController extends Controller
{
    function index() {
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[1])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-pengantar.skripsi.index', compact('data'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'array', 'min:1'],
            'registration_number' => ['required', 'array', 'min:1'],
            'research_purpose' => ['required', 'string'],
            'research_title' => ['required', 'string'],
            'company_name' => ['required', 'string'],
            'company_division' => ['required', 'string'],
            'company_phone' => ['required', 'numeric'],
            'starting_date' => ['required', 'date'],
            'company_address' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        foreach ($request->name as $key => $name) {
            if ($name != null && $request->registration_number[$key] == null) {
                return back()->withErrors(['registration_number' => 'NPM tidak boleh kosong jika nama sudah di isi'])->withInput();
            } else if ($name == null && $request->registration_number[$key] != null) {
                return back()->withErrors(['registration_number' => 'Nama tidak boleh kosong jika NPM sudah di isi'])->withInput();
            }
        }

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[1],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-pengantar.skripsi.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-pengantar.skripsi.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-pengantar.skripsi.index', compact('submission'))->render();
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
