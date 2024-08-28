<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Office>
 */
class OfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $offices = [
            'Ilobasco',
            'San Salvador',
            'Santa Ana',
            'San Miguel',
            'Usulután',
            'San Vicente',
            'La Unión',
            'Morazán',
            'La Paz',
            'Cabañas',
            'Chalatenango',
            'Sonsonate',
            'Ahuachapán',
            'La Libertad',
        ];

        return [
            'location' => $this->faker->unique()->randomElement($offices),
        ];
    }
}
