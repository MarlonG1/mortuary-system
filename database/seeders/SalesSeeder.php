<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Office;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::factory()
            ->count(25)
            ->has(Office::factory()->count(1))
            ->has(Service::factory()->count(1))
            ->create();

        Sale::factory()
            ->count(25)
            ->has(Office::factory()->count(1))
            ->has(Service::factory()->count(2))
            ->create();
    }
}
