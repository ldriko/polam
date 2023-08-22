<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'employee_position_id',
        'department_id',
        'name',
        'email',
        'registration_type',
        'registration_number',
        'signature',
        'password',
    ];
}
