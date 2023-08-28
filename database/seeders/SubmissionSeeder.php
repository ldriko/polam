<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Submission;
use App\Models\User;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        Submission::create([
            'user_id' => $user->id,
            'type' => 'pkl',
            'data' => '{"name":["Anwarul Fattach","Mahasiswa 2","Mahasiwa 3",null],"registration_number":["18081010097","18081010098","18081010089",null],"company_name":"Nama Instansinya","company_division":"Nama Divisinya","company_phone":"083830803219","starting_date":"2023-08-31","company_address":"Alamat Perusahaannya","note":"Catatan Khusus"}',
        ]);
    }
}
