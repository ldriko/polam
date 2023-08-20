<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'name',
        'short_name',
        'description',
    ];

    protected $masterLevels = [
        0 => 'admin',
        1 => 'dekan',
        2 => 'wakil dekan',
        3 => 'koorprodi',
        4 => 'staff tu',
    ];
}
