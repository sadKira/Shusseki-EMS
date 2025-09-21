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

        // Super Admin
        User::create([
            'student_id' => '0000000',
            'name' => 'Master Admin',
            'email' => 'masteradmin@shusseki.com',
            'role' => UserRole::Super_Admin,
            'password' => Hash::make("mkd2025-masteradmin"),
            'status' => 'approved',
            'year_level' => 'null',
            'course' => 'null',
            'account_status' => 'active',
            'privilege' => 'yes'
        ]);

        // Super Admin
        User::create([
            'student_id' => '0000001',
            'name' => 'Super Admin',
            'email' => 'superadmin@shusseki.com',
            'role' => UserRole::Super_Admin,
            'password' => Hash::make("mkd2025-superadmin"),
            'status' => 'approved',
            'year_level' => 'null',
            'course' => 'null',
            'account_status' => 'active',
            'privilege' => 'yes'
        ]);
    }
}
