<?php

namespace App\Http\Controllers\Admin\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;

class PklController extends Controller
{
    function index(Request $request) {
        $submissions = Submission::where('type', 'pkl')->orderBy('created_at', 'desc')->get();
        return view('admin.surat-pengantar.pkl.index', compact('submissions'));
    }

    function show(Request $request, Submission $submission) {
        return view('admin.surat-pengantar.pkl.show', compact('submission'));
    }
}
