<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceDetail>
 */
class ServiceDetailFactory extends Factory
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
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'initial_stock' => $initialStock,
            'current_stock' => $currentStock,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
