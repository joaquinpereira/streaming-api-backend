<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PromoCode::factory(5)->create();
        
        \App\Models\PromoCode::firstOrCreate([
            'code' => 'WELCOME2025',
        ], [
            'discount_percentage' => 20.00,
            'expires_at' => now()->addYear(),
            'max_uses' => 1000,
        ]);
    }
}
