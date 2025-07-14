<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;


class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'student_id' => '0000001',
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => UserRole::Super_Admin,
            'password' => Hash::make("password"),
            'status' => 'approved',
            'year_level' => 'null',
            'course' => 'null',
            'account_status' => 'active'
        ]);
    }
}
