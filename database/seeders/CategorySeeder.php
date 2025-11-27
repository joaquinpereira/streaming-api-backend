<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Documentary'];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['name' => $category],
                ['slug' => \Illuminate\Support\Str::slug($category)]
            );
        }
    }
}
