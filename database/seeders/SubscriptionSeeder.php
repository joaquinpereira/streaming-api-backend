<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $plans = \App\Models\Plan::all();

        if ($users->isEmpty() || $plans->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // 50% chance to have a subscription
            if (rand(0, 1)) {
                $subscription = \App\Models\Subscription::factory()->create([
                    'user_id' => $user->id,
                    'plan_id' => $plans->random()->id,
                ]);

                \App\Models\Payment::factory()->create([
                    'subscription_id' => $subscription->id,
                    'amount' => $subscription->plan->price,
                ]);
            }
        }
    }
}
