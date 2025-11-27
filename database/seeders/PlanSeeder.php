<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'price' => 9.99,
                'duration_days' => 30,
                'max_devices' => 1,
            ],
            [
                'name' => 'Standard',
                'price' => 14.99,
                'duration_days' => 30,
                'max_devices' => 2,
            ],
            [
                'name' => 'Premium',
                'price' => 19.99,
                'duration_days' => 30,
                'max_devices' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::firstOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
