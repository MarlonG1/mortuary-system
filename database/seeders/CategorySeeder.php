<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $productCategories = [
            ['name' => 'Food', 'details' => $faker->paragraph(1), 'type' => 'Product', 'stock' => true],
            ['name' => 'Flowers', 'details' => $faker->paragraph(1), 'type' => 'Product', 'stock' => true],
            ['name' => 'Casket', 'details' => $faker->paragraph(1), 'type' => 'Product', 'stock' => true],
            ['name' => 'Urn', 'details' => $faker->paragraph(1), 'type' => 'Product', 'stock' => false],
            ['name' => 'Headstone', 'details' => $faker->paragraph(1), 'type' => 'Product', 'stock' => false],
            ['name' => 'Vault', 'details' => $faker->paragraph(1), 'type' => 'Product', 'stock' => false],
        ];

        $serviceCategories = [
            ['name' => 'Funeral', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => false],
            ['name' => 'Cremation', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => false],
            ['name' => 'Burial', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => false],
            ['name' => 'Memorial', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Visitation', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Graveside', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Reception', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Transportation', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Casketing', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Embalming', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Dressing', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Cosmetology', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Hairdressing', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Restoration', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Shipping', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Receiving', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Direct', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Forwarding', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Crematory', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Cemetery', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Church', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
            ['name' => 'Chapel', 'details' => $faker->paragraph(1), 'type' => 'Service', 'stock' => true],
        ];

        foreach ($productCategories as $category) {
            Category::create($category);
        }

        foreach ($serviceCategories as $category) {
            Category::create($category);
        }
    }
}
