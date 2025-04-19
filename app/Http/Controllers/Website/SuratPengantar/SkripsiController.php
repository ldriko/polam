<?php

namespace App\Http\Controllers\Website\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Submission;
use App\Models\Guide;

class SkripsiController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[1])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[1])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-pengantar.skripsi.index', compact('data', 'guide'));
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
        ], [
            'name.required' => 'Nama mahasiswa wajib diisi',
            'name.array' => 'Format nama mahasiswa tidak valid',
            'name.min' => 'Minimal 1 nama mahasiswa harus diisi',
            'registration_number.required' => 'NPM mahasiswa wajib diisi',
            'registration_number.array' => 'Format NPM mahasiswa tidak valid', 
            'registration_number.min' => 'Minimal 1 NPM mahasiswa harus diisi',
            'research_purpose.required' => 'Keperluan penelitian wajib diisi',
            'research_purpose.string' => 'Format keperluan penelitian tidak valid',
            'research_title.required' => 'Judul penelitian wajib diisi',
            'research_title.string' => 'Format judul penelitian tidak valid',
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_name.string' => 'Format nama perusahaan tidak valid',
            'company_division.required' => 'Divisi/bagian perusahaan wajib diisi',
            'company_division.string' => 'Format divisi/bagian perusahaan tidak valid',
            'company_phone.required' => 'Nomor telepon perusahaan wajib diisi',
            'company_phone.numeric' => 'Nomor telepon harus berupa angka',
            'starting_date.required' => 'Tanggal mulai penelitian wajib diisi',
            'starting_date.date' => 'Format tanggal tidak valid',
            'company_address.required' => 'Alamat perusahaan wajib diisi',
            'company_address.string' => 'Format alamat perusahaan tidak valid',
            'note.string' => 'Format catatan tidak valid'
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
