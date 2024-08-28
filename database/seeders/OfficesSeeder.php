<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::factory()->count(7)
            ->has(Employee::factory()->count(1)->hasUser(1))
            ->create();

        Office::factory()->count(7)
            ->has(Employee::factory()->count(50))
            ->create();
    }
}
