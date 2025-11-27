<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subscription_id' => \App\Models\Subscription::factory(),
            'amount' => fake()->randomFloat(2, 5, 20),
            'payment_method' => fake()->creditCardType(),
            'transaction_id' => fake()->unique()->uuid(),
            'status' => fake()->randomElement(['Success', 'Failed', 'Pending']),
        ];
    }
}
