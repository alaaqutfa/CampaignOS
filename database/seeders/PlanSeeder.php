<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'price' => 29.00,
                'billing_cycle' => 'monthly',
                'user_limit' => 5,
                'campaign_limit' => 10,
                'storage_limit' => 5 * 1024 * 1024 * 1024, // 5 GB
                'features' => ['Basic Support', 'API Access'],
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Professional',
                'price' => 99.00,
                'billing_cycle' => 'monthly',
                'user_limit' => 25,
                'campaign_limit' => 50,
                'storage_limit' => 50 * 1024 * 1024 * 1024, // 50 GB
                'features' => ['Priority Support', 'API Access', 'Advanced Analytics'],
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'price' => 299.00,
                'billing_cycle' => 'monthly',
                'user_limit' => null,
                'campaign_limit' => null,
                'storage_limit' => null,
                'features' => ['Dedicated Support', 'API Access', 'Custom Integrations'],
                'is_popular' => false,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
