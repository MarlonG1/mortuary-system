<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Office;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Sale;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = Office::all();
        $serviceCategory = Category::where('type', 'Service')->get();
        $productCategory = Category::where('type', 'Product')->get();

        Customer::factory()
            ->count(50)
            ->create();

        Customer::factory()
            ->count(25)
            ->has(Sale::factory()->count(1)
                ->for($offices->random())
                ->has(Service::factory()->count(1)
                    ->for($serviceCategory->random())
                    ->has(ServiceDetail::factory()->count(1))
                    ->has(Product::factory()->count(3)
                        ->has(ProductDetails::factory()->count(1))
                    )
                )
            )
            ->create()
            ->each(function ($customer) use ($productCategory) {
                $customer->sales->each(function ($sale) use ($productCategory) {
                    $sale->services->each(function ($service) use ($productCategory) {
                        $service->products->each(function ($product) use ($productCategory) {
                            $product->categories()->attach($productCategory->random(rand(1,2)));
                        });
                    });
                });
            });

        Customer::factory()
            ->count(5)
            ->has(Sale::factory()->count(2)
                ->for($offices->random())
                ->has(Service::factory()->count(3)
                    ->for($serviceCategory->random())
                    ->has(ServiceDetail::factory()->count(1))
                    ->has(Product::factory()->count(2)
                        ->has(ProductDetails::factory()->count(1))
                    )
                )
            )
            ->create()
            ->each(function ($customer) use ($productCategory) {
                $customer->sales->each(function ($sale) use ($productCategory) {
                    $sale->services->each(function ($service) use ($productCategory) {
                        $service->products->each(function ($product) use ($productCategory) {
                            $product->categories()->attach($productCategory->random(rand(1,3)));
                        });
                    });
                });
            });

        Customer::factory()
            ->count(5)
            ->has(Sale::factory()->count(2)
                ->for($offices->random())
                ->has(Service::factory()->count(3)
                    ->for($serviceCategory->random())
                    ->has(ServiceDetail::factory()->count(1))
                    ->has(Product::factory()->count(2)
                        ->has(ProductDetails::factory()->count(1))
                    )
                )
            )
            ->create()
            ->each(function ($customer) use ($productCategory) {
                $customer->sales->each(function ($sale) use ($productCategory) {
                    $sale->services->each(function ($service) use ($productCategory) {
                        $service->products->each(function ($product) use ($productCategory) {
                            $product->categories()->attach($productCategory->random(rand(1,3)));
                        });
                    });
                });
            });

        Customer::factory()
            ->count(5)
            ->has(Sale::factory()->count(2)
                ->for($offices->random())
                ->has(Service::factory()->count(3)
                    ->for($serviceCategory->random())
                    ->has(ServiceDetail::factory()->count(1))
                    ->has(Product::factory()->count(2)
                        ->has(ProductDetails::factory()->count(1))
                    )
                )
            )
            ->create()
            ->each(function ($customer) use ($productCategory) {
                $customer->sales->each(function ($sale) use ($productCategory) {
                    $sale->services->each(function ($service) use ($productCategory) {
                        $service->products->each(function ($product) use ($productCategory) {
                            $product->categories()->attach($productCategory->random(rand(1,3)));
                        });
                    });
                });
            });

        Customer::factory()
            ->count(10)
            ->has(Sale::factory()->count(2)
                ->for($offices->random())
                ->has(Service::factory()->count(3)
                    ->for($serviceCategory->random())
                    ->has(ServiceDetail::factory()->count(1))
                    ->has(Product::factory()->count(2)
                        ->has(ProductDetails::factory()->count(1))
                    )
                )
            )
            ->create()
            ->each(function ($customer) use ($productCategory) {
                $customer->sales->each(function ($sale) use ($productCategory) {
                    $sale->services->each(function ($service) use ($productCategory) {
                        $service->products->each(function ($product) use ($productCategory) {
                            $product->categories()->attach($productCategory->random(rand(1,3)));
                        });
                    });
                });
            });
    }
}
