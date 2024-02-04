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
    ];

    protected $types = [
        'pkl' // Surat pengajuan pkl
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
        return Carbon::parse($this->created_at)->locale('id')->translatedFormat('d F Y H:i');
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
}
