<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('PROMO-####')),
            'discount_percentage' => fake()->randomFloat(2, 5, 50),
            'expires_at' => fake()->dateTimeBetween('now', '+1 year'),
            'max_uses' => fake()->numberBetween(10, 100),
            'current_uses' => fake()->numberBetween(0, 10),
        ];
    }
}
