<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء شركة تجريبية
        $company = Company::firstOrCreate(
            ['name' => 'Demo Company'],
            [
                'commercial_name' => 'Demo Street Advertising',
                'contact_info'    => ['email' => 'info@democompany.com', 'phone' => '1234567890'],
                'status'          => true,
            ]
        );

        // مستخدم مدير الشركة (company_admin)
        $admin = User::firstOrCreate(
            ['email' => 'demo@alaaqutfa.tech'],
            [
                'name'      => 'Demo Admin',
                'password'  => bcrypt('123123123'),
                'company_id'=> $company->id,
                'is_super_admin' => false,
            ]
        );
        $admin->assignRole('company_admin');

        // مستخدم مقاول قياس (measurer)
        $measurer = User::firstOrCreate(
            ['email' => 'measurer@alaaqutfa.tech'],
            [
                'name'      => 'Demo Measurer',
                'password'  => bcrypt('123123123'),
                'company_id'=> $company->id,
                'is_super_admin' => false,
            ]
        );
        $measurer->assignRole(['measurer', 'installer']);

        // مستخدم مقاول تركيب (installer)
        $installer = User::firstOrCreate(
            ['email' => 'installer@alaaqutfa.tech'],
            [
                'name'      => 'Demo Installer',
                'password'  => bcrypt('123123123'),
                'company_id'=> $company->id,
                'is_super_admin' => false,
            ]
        );
        $installer->assignRole(['measurer', 'installer']);
    }
}
