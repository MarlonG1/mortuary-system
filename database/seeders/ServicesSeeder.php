<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::where('type', 'Service')->get();

        Service::factory()
            ->count(50)
            ->for($categories->random())
            ->has(Product::factory()->count(5)->hasProductDetail(1))
            ->has(ServiceDetail::factory()->count(1))
            ->create()
            ->each( function ($services) {
                $services->products->each( function ($product) {
                    $product->categories()->attach(Category::where('type', 'Product')->get()->random(rand(1, 2)));
                });
            });
    }
}
