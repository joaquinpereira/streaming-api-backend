<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentFile>
 */
class ContentFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content_type' => fake()->randomElement(['App\Models\Movie', 'App\Models\Episode']),
            'content_id' => fake()->numberBetween(1, 100), // Placeholder, should be handled by seeder or state
            'video_url' => fake()->url(),
            'mime_type' => 'video/mp4',
        ];
    }
}
