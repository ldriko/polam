<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Informatika',
                'short_name' => 'IF',
                'description' => 'Jurusan Informatika',
            ],
            [
                'name' => 'Sistem Informasi',
                'short_name' => 'SI',
                'description' => 'Jurusan Sistem Informasi',
            ],
            [
                'name' => 'Sains Data',
                'short_name' => 'SD',
                'description' => 'Jurusan Sains Data',
            ],
            [
                'name' => 'Bisnis Digital',
                'short_name' => 'DB',
                'description' => 'Jurusan Bisnis Digital',
            ],
        ];

        Department::insert($departments);
    }
}
