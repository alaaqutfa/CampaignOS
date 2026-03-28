<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\MeasurementAsset;
use App\Models\City;
use App\Models\Region;
use App\Models\Shop;
use App\Models\Workflow;
use App\Models\DesignJob;
use App\Models\AuditLog;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // جلب المستخدمين من الشركة التجريبية
        $demoCompany = \App\Models\Company::where('name', 'Demo Company')->first();
        if (!$demoCompany) {
            $this->command->warn('Demo company not found. Skipping demo data.');
            return;
        }

        $companyAdmin = User::where('email', 'demo@alaaqutfa.tech')->first();
        $measurer    = User::where('email', 'measurer@alaaqutfa.tech')->first();
        $installer   = User::where('email', 'installer@alaaqutfa.tech')->first();

        if (!$companyAdmin || !$measurer || !$installer) {
            $this->command->warn('Required demo users not found. Run DemoUserSeeder first.');
            return;
        }

        // الحصول على الحملات أو إنشاء حملة افتراضية
        $campaigns = Campaign::where('company_id', $demoCompany->id)->get();
        if ($campaigns->isEmpty()) {
            $campaign = Campaign::factory()->create([
                'company_id' => $demoCompany->id,
                'created_by' => $companyAdmin->id,
            ]);
            $campaigns = collect([$campaign]);
        }

        foreach ($campaigns as $campaign) {
            // 1. إنشاء مدينة ومنطقة للمشروع إن لم توجد
            $city = City::firstOrCreate(
                ['company_id' => $demoCompany->id, 'name' => 'Demo City'],
                ['name' => 'Demo City']
            );

            $region = Region::firstOrCreate(
                ['city_id' => $city->id, 'name' => 'Downtown'],
                ['name' => 'Downtown']
            );

            // 2. إنشاء محلات متعددة للمشروع
            for ($i = 1; $i <= 3; $i++) {
                $shop = Shop::firstOrCreate(
                    ['company_id' => $demoCompany->id, 'name' => "Shop $i"],
                    [
                        'city_id'   => $city->id,
                        'region_id' => $region->id,
                        'address'   => $faker->streetAddress,
                    ]
                );

                // 3. إنشاء عنصر قياس واحد على الأقل لكل محل
                $item = CampaignItem::factory()->create([
                    'campaign_id'           => $campaign->id,
                    'shop_id'               => $shop->id,
                    'recorded_by'           => $companyAdmin->id,
                    'assigned_measurer_id'  => $measurer->id,
                    'assigned_installer_id' => $installer->id,
                ]);

                // 4. إضافة صورة قبل وأخرى بعد (للتجربة)
                foreach (['before', 'after'] as $type) {
                    MeasurementAsset::factory()->create([
                        'campaign_item_id' => $item->id,
                        'type'             => $type,
                        'uploaded_by'      => $companyAdmin->id,
                    ]);
                }
            }

            // 5. سير عمل
            Workflow::create([
                'campaign_id' => $campaign->id,
                'stage'       => 'design',
                'status'      => 'pending',
                'assigned_to' => $measurer->id,
            ]);

            // 6. مهام التصميم (مثال)
            DesignJob::create([
                'campaign_id'   => $campaign->id,
                'created_by'    => $companyAdmin->id,
                'template_name' => 'Standard Billboard',
                'input_payload' => json_encode(['width' => 100, 'height' => 200]),
                'status'        => 'pending',
            ]);

            // 7. سجل التدقيق
            AuditLog::create([
                'user_id'      => $companyAdmin->id,
                'action'       => 'created',
                'entity_type'  => 'App\Models\Campaign',
                'entity_id'    => $campaign->id,
                'changes'      => json_encode(['before' => null, 'after' => $campaign->toArray()]),
                'ip_address'   => $faker->ipv4,
                'user_agent'   => $faker->userAgent,
            ]);

            // 8. مشكلة واحدة
            Issue::create([
                'campaign_id'   => $campaign->id,
                'title'         => 'Measurement mismatch',
                'description'   => 'The width is not matching the shop entrance.',
                'status'        => 'open',
                'priority'      => 'medium',
                'reported_by'   => $companyAdmin->id,
            ]);
        }

        // 9. تعيين المناطق للمقاولين
        // هنا نقوم بربط المقاولين بالمنطقة التي أنشأناها (لكل من القياس والتركيب)
        $region = Region::where('name', 'Downtown')->first();
        if ($region) {
            // ربط المقاول القياس بهذه المنطقة
            $measurer->assignedRegions()->syncWithoutDetaching([$region->id => ['assignment_type' => 'measure']]);
            // ربط المقاول التركيب بهذه المنطقة
            $installer->assignedRegions()->syncWithoutDetaching([$region->id => ['assignment_type' => 'install']]);
        }

        $this->command->info('Demo data seeded successfully.');
    }
}
