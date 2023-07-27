<?php

namespace App\Http\Controllers\Website\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PklController extends Controller
{
    function index() {
        return view('website.surat-pengantar.pkl.index');
    }
}
