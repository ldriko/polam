<?php

namespace App\Http\Controllers\Website\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Submission;
use App\Models\Guide;

class PenelitianMatkulController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[2])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[2])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-pengantar.penelitian-matkul.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'array', 'min:1'],
            'registration_number' => ['required', 'array', 'min:1'],
            'subject_name' => ['required', 'string'],
            'application_letter' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'research_purpose' => ['required', 'string'],
            'research_title' => ['required', 'string'],
            'company_name' => ['required', 'string'],
            'company_division' => ['required', 'string'],
        ]);

        foreach ($request->name as $key => $name) {
            if ($name != null && $request->registration_number[$key] == null) {
                return back()->withErrors(['registration_number' => 'NPM tidak boleh kosong jika nama sudah di isi'])->withInput();
            } else if ($name == null && $request->registration_number[$key] != null) {
                return back()->withErrors(['registration_number' => 'Nama tidak boleh kosong jika NPM sudah di isi'])->withInput();
            }
        }

        // upload pdf dulu
        $request->application_letter_path = null;
        if ($request->file('application_letter')->isValid()) {
            $path = $request->application_letter->store('surat-pengantar/penelitian-matkul');
            if ($path) {
                $request->merge(['application_letter_path' => $path]);
            } else {
                return redirect()->route('surat-pengantar.penelitian-matkul.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload surat ajuan',
                ]);
            }
        }

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[2],
            'data' => json_encode($request->except(['_token', 'application_letter'])),
        ]);

        if ($create) {
            return redirect()->route('surat-pengantar.penelitian-matkul.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-pengantar.penelitian-matkul.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-pengantar.penelitian-matkul.index', compact('submission'))->render();
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
