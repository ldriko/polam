<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
