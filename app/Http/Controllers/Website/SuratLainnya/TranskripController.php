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
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[8])->with('user')->orderBy('created_at', 'desc')->get();
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
        $startSemester = Carbon::now()->startOfMonth()->setMonth(1); // 1 Januari
        $endSemester = Carbon::now()->startOfMonth()->setMonth(6)->endOfMonth(); // 30 Juni

        // jika bulan sekarang > juni
        if ($now->month > 6 || true) {
            // prepare semester ganjil
            $startSemester = Carbon::now()->startOfMonth()->setMonth(7); // 1 Juli
            $endSemester = Carbon::now()->startOfMonth()->setMonth(12)->endOfMonth(); // 31 Desember
        }

        $isAlreadyAsk = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[8])->whereDate('approved_at', '>=', $startSemester)->whereDate('approved_at', '<=', $endSemester)->first();

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

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // get data tambahan
        $dekan = Employee::whereHas('position', function ($query) {
            $query->where('code', 'dekan');
        })->latest()->first();

        // Prepare PDF nya
        $file = view('pdf.surat-lainnya.transkrip.index', compact('submission', 'dekan'))->render();
        // return $file;
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
