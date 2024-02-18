<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'code',
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

    function getAllowedToVerifyAttribute() {
        // karena cuman staff dan admin yg bisa verif, jadinya gini aja udah aman
        if (in_array($this->level, [0, 4])) {
            return true;
        }
        return false;
    }

    function getAllowedToApproveAttribute() {
        if (in_array($this->level, [0, 1, 2])) {
            return true;
        }
        return false;
    }
}
