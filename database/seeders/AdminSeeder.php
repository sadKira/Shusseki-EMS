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
        User::create([
            'name' => 'view_1',
            'email' => 'admin@example.com',
            'role' => UserRole::Admin,
            'password' => Hash::make("password"),
            'status' => 'approved',
            'year_level' => 'null',
            'course' => 'null',
            'account_status' => 'active'

        ]);
    }
}
