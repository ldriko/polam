<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'department_id' => 1,
            'name' => 'Anwarul Fattach',
            'email' => '18081010097@student.upnjatim.ac.id',
            'registration_number' => '18081010097',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('pastibisa'),
        ]);
    }
}
