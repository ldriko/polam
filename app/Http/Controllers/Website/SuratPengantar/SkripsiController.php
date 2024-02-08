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
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[1])->with('user')->orderBy('created_at', 'desc')->get();
        return view('website.surat-pengantar.skripsi.index', compact('data'));
    }
}
