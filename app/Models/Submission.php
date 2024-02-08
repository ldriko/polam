<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Employee\Employee;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'verified_at',
        'verified_by',
        'approved_at',
        'approved_by',
        'letter_number',
    ];

    public const TYPES = [
        'pkl', // Surat pengajuan pkl
        'skripsi', // Surat pengajuan skripsi
    ];

    public const ROMAN_MONTH = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function verifiedByEmployee() {
        return $this->belongsTo(Employee::class, 'verified_by', 'id');
    }

    function approvedByEmployee() {
        return $this->belongsTo(Employee::class, 'approved_by', 'id');
    }

    function getFormattedCreatedAtAttribute() {
        return Carbon::parse($this->created_at)->locale('id_ID')->translatedFormat('d F Y H:i');
    }

    function getStatusAttribute() {
        if ($this->approved_at != null) {
            return 'Telah Disetujui';
        }

        if ($this->verified_at != null) {
            return 'Menunggu Persetujuan';
        }

        return 'Menunggu Verifikasi';
    }

    function getStatusBadgeAttribute() {
        if ($this->approved_at && $this->verified_at) {
            return 'success';
        }

        return 'warning';
    }

    function getFormattedLetterNumberAttribute() {
        $approvedAt = Carbon::parse($this->approved_at)->locale('id_ID');
        return $this->letter_number . '/UN.63.7/' . Submission::ROMAN_MONTH[$approvedAt->translatedFormat('n')] . '/' . $approvedAt->translatedFormat('Y');
    }
}
