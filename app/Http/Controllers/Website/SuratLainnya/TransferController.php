<?php

namespace App\Http\Controllers\Website\SuratLainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee\Employee;
use App\Models\Guide;

class TransferController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[6])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[6])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-lainnya.transfer.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'parent_name' => ['required', 'string'],
            'university' => ['required', 'string'],
            'faculty' => ['required', 'string'],
            'new_department' => ['required', 'string'],
        ]);

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[6],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-lainnya.transfer.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-lainnya.transfer.index')->with([
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
        $file = view('pdf.surat-lainnya.transfer.index', compact('submission', 'dekan'))->render();
        // return $file;
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}
