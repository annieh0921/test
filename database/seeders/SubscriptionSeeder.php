<?php

namespace Database\Seeders;

use App\Models\Subscription\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptions = [
            [
                'name' => 'basic',
                'duration' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'premium',
                'duration' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'pro',
                'duration' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Subscription::query()->insert($subscriptions);
    }
}
