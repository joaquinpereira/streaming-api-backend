<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Series>
 */
class SeriesFactory extends Factory
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
            'release_year_start' => fake()->year(),
            'release_year_end' => fake()->optional()->year(),
            'tmdb_id' => fake()->unique()->numerify('#####'),
            'poster_url' => fake()->imageUrl(),
            'rating' => fake()->randomFloat(1, 1, 10),
        ];
    }
}
