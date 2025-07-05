<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolYear;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [
            '2022-2023',
            '2023-2024',
            '2024-2025',
            '2025-2026',
        ];

        foreach ($years as $year) {
            SchoolYear::updateOrCreate(['year' => $year]);
        }
    }
}
