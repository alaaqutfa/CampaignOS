<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $demoUser = User::where('email', 'demo@alaaqutfa.tech')->first();

        if ($demoUser && $demoUser->company_id) {
            // إنشاء 5 حملات للمستخدم التجريبي
            Campaign::factory(5)->create([
                'company_id' => $demoUser->company_id,
                'created_by' => $demoUser->id,
            ]);
        }
    }
}
