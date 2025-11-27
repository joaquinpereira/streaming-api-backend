<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();

        \App\Models\Series::factory(5)->create()->each(function ($series) use ($categories) {
            $series->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            \App\Models\Season::factory(rand(1, 3))->create([
                'series_id' => $series->id,
            ])->each(function ($season) {
                \App\Models\Episode::factory(rand(3, 5))->create([
                    'season_id' => $season->id,
                ])->each(function ($episode) {
                    \App\Models\ContentFile::factory()->create([
                        'content_type' => \App\Models\Episode::class,
                        'content_id' => $episode->id,
                    ]);
                });
            });
        });
    }
}
