<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();

        \App\Models\Movie::factory(10)->create()->each(function ($movie) use ($categories) {
            $movie->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            \App\Models\ContentFile::factory()->create([
                'content_type' => \App\Models\Movie::class,
                'content_id' => $movie->id,
            ]);
        });
    }
}
