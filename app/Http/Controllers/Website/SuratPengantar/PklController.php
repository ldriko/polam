<?php

namespace App\Http\Controllers\Website\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PklController extends Controller
{
    function index() {
        $submissions = Submission::where('user_id', Auth::id())->where('type', 'pkl')->with('user')->orderBy('created_at', 'desc')->get();
        return view('website.surat-pengantar.pkl.index', compact('submissions'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'array', 'min:1'],
            'registration_number' => ['required', 'array', 'min:1'],
            'company_name' => ['required', 'string'],
            'company_division' => ['required', 'string'],
            'company_phone' => ['required', 'numeric'],
            'starting_date' => ['required', 'date'],
            'company_address' => ['required', 'string'],
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
            'type' => 'pkl',
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-pengantar.pkl.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-pengantar.pkl.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-pengantar.pkl.index', compact('submission'))->render();
        // return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
        return $file;
    }
}
