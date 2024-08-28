<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDetails>
 */
class ProductDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        $initialStock = $this->faker->numberBetween(50, 500);
        $currentStock = $this->faker->numberBetween(0, $initialStock);

        return [
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'initial_stock' => $initialStock,
            'current_stock' => $currentStock,
            'image' => $faker->imageUrl(),
        ];
    }
}
