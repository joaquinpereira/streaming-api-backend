<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word() . ' Plan',
            'price' => fake()->randomFloat(2, 5, 20),
            'duration_days' => fake()->randomElement([30, 365]),
            'max_devices' => fake()->numberBetween(1, 4),
        ];
    }
}
