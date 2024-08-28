<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => $this->faker->randomFloat(2, 0, 1000),
            'sale_date' => $this->faker->date(),
            'execution_date' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
