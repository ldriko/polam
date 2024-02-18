<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee\EmployeePosition;

class EmployeePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'level' => 0,
                'code' => 'admin',
                'name' => 'admin',
                'short_name' => 'admin',
                'description' => 'jabatan admin',
            ],
            [
                'level' => 1,
                'code' => 'dekan',
                'name' => 'dekan',
                'short_name' => 'dekan',
                'description' => 'jabatan dekan',
            ],
            [
                'level' => 2,
                'code' => 'wadek-1',
                'name' => 'wakil dekan 1',
                'short_name' => 'wadek 1',
                'description' => 'jabatan wadek 1',
            ],
            [
                'level' => 2,
                'code' => 'wadek-2',
                'name' => 'wakil dekan 2',
                'short_name' => 'wadek 2',
                'description' => 'jabatan wadek 2',
            ],
            [
                'level' => 2,
                'code' => 'wadek-3',
                'name' => 'wakil dekan 3',
                'short_name' => 'wadek 3',
                'description' => 'jabatan wadek 3',
            ],
            [
                'level' => 3,
                'code' => 'koorprodi',
                'name' => 'koorprodi',
                'short_name' => 'koorprodi',
                'description' => 'jabatan koorprodi',
            ],
            [
                'level' => 4,
                'code' => 'staff',
                'name' => 'staff tu',
                'short_name' => 'staff',
                'description' => 'jabatan staff',
            ],
        ];

        EmployeePosition::insert($positions);
    }
}
