<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'synopsis' => fake()->paragraph(),
            'release_year' => fake()->year(),
            'duration_min' => fake()->numberBetween(60, 180),
            'tmdb_id' => fake()->unique()->numerify('#####'),
            'poster_url' => fake()->imageUrl(),
            'rating' => fake()->randomFloat(1, 1, 10),
        ];
    }
}
