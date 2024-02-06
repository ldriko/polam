<?php

namespace App\Http\Controllers\Admin\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PklController extends Controller
{
    function index(Request $request) {
        $submissions = Submission::where('type', 'pkl')->orderBy('created_at', 'desc')->get();
        return view('admin.surat-pengantar.pkl.index', compact('submissions'));
    }

    function show(Request $request, Submission $submission) {
        return view('admin.surat-pengantar.pkl.show', compact('submission'));
    }

    function verify(Request $request, Submission $submission) {
        $submission->update([
            'verified_by' => Auth::guard('employee')->id(),
            'verified_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.surat-pengantar.pkl.index')->with([
            'status' => 'success',
            'message' => 'Ajuan berhasil diverifikasi',
        ]);
    }

    function approve(Request $request, Submission $submission) {
        // untuk ambil current month and year
        $now = Carbon::now();

        // prepare nomor surat, default 1
        $letterNumber = 1;

        // get nomor surat terakhir di bulan dan tahun ini
        $lastSubmissionThisMonth = Submission::whereMonth('approved_at', $now->month)->whereYear('approved_at', $now->year)->orderBy('letter_number', 'desc')->first();

        if ($lastSubmissionThisMonth) {
            $letterNumber = $lastSubmissionThisMonth->letter_number + 1;
        }

        $submission->update([
            'approved_by' => Auth::guard('employee')->id(),
            'approved_at' => Carbon::now(),
            'letter_number' => $letterNumber,
        ]);

        return redirect()->route('admin.surat-pengantar.pkl.index')->with([
            'status' => 'success',
            'message' => 'Ajuan berhasil disetujui',
        ]);
    }
}
