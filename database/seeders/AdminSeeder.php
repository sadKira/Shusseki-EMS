<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin 1
        User::create([
            'student_id' => '0000002',
            'name' => 'Admin 1',
            'email' => 'admin1@shusseki.com',
            'role' => UserRole::Admin,
            'password' => Hash::make("password"),
            'status' => 'approved',
            'year_level' => 'null',
            'course' => 'null',
            'account_status' => 'active',
            'privilege' => 'no',

        ]);

        // Admin 2
        User::create([
            'student_id' => '0000003',
            'name' => 'Admin 2',
            'email' => 'admin2@shusseki.com',
            'role' => UserRole::Admin,
            'password' => Hash::make("password"),
            'status' => 'approved',
            'year_level' => 'null',
            'course' => 'null',
            'account_status' => 'active',
            'privilege' => 'no',

        ]);
    }
}
