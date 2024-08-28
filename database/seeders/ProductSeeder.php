<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductDetails;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = Category::where('type', 'product')->get();




        Product::factory()
            ->count(50)
            ->has(ProductDetails::factory()->count(1))
            ->for($categories->random(2))
            ->create();
    }
}
