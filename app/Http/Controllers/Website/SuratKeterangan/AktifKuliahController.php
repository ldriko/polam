<?php

namespace App\Http\Controllers\Website\SuratKeterangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Guide;

class AktifKuliahController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[3])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[3])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-keterangan.aktif-kuliah.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'academic_year' => ['required', 'string'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'parent_name' => ['required', 'string'],
            'parent_company_name' => ['required', 'string'],
            'parent_employee_number' => ['nullable', 'string'],
            'parent_employee_position' => ['nullable', 'string'],
            'used_for' => ['required', 'string'],
            'proof_re_registration' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        // upload pdf dulu
        if ($request->file('proof_re_registration')->isValid()) {
            $path = $request->proof_re_registration->store('surat-keterangan/aktif-kuliah');
            if ($path) {
                $request->merge(['proof_re_registration_path' => $path]);
            } else {
                return redirect()->route('surat-keterangan.aktif-kuliah.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload surat ajuan',
                ]);
            }
        }

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[3],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-keterangan.aktif-kuliah.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-keterangan.aktif-kuliah.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-keterangan.aktif-kuliah.index', compact('submission'))->render();
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
