<?php

namespace App\Http\Controllers\Website\SuratLainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee\Employee;
use Carbon\Carbon;

class TranskripController extends Controller
{
    function index() {
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[8])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-lainnya.transkrip.index', compact('data'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
        ]);

        $now = Carbon::now();

        // prepare semester genap
        $startSemester = Carbon::now()->startOfMonth()->setMonth(2); // 1 Februari Tahun Ini
        $endSemester = Carbon::now()->startOfMonth()->setMonth(7)->endOfMonth(); // 31 Juli Tahun Ini

        
        // jika bulan sekarang > juni
        if ($now->month > 6 || true) {
            // prepare semester ganjil
            $startSemester = Carbon::now()->startOfMonth()->setMonth(8); // 1 Agustus Tahun Ini
            $endSemester = Carbon::now()->startOfMonth()->setMonth(1)->endOfMonth()->addYears(1); // 31 Januari Tahun Depan
        }

        $isAlreadyAsk = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[8])
        ->where(function ($query) use ($startSemester, $endSemester) {
            $query->whereNull('approved_at')->whereNull('rejected_at')
            ->whereDate('created_at', '>=', $startSemester)->whereDate('created_at', '<=', $endSemester);
        })
        ->orWhere(function ($query) use ($startSemester, $endSemester) {
            $query->whereDate('approved_at', '>=', $startSemester)->whereDate('approved_at', '<=', $endSemester);
        })
        ->first();

        if ($isAlreadyAsk) {
            return redirect()->route('surat-lainnya.transkrip.index')->with([
                'status' => 'error',
                'message' => 'Sudah pernah mengajukan dalam kurun waktu 1 semester',
            ]);
        }

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[8],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-lainnya.transkrip.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-lainnya.transkrip.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }
}
