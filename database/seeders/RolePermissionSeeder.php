<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions
        $permissions = [
            // Campaigns
            'view campaigns', 'create campaigns', 'update campaigns', 'delete campaigns',
            // Campaign Items
            'view campaign_items', 'create campaign_items', 'update campaign_items', 'delete campaign_items',
            // Design Jobs
            'view design_jobs', 'create design_jobs', 'update design_jobs', 'delete design_jobs',
            // Issues
            'view issues', 'create issues', 'update issues', 'delete issues',
            // Measurement Assets
            'view measurement_assets', 'create measurement_assets', 'update measurement_assets', 'delete measurement_assets',
            // Workflows
            'view workflows', 'create workflows', 'update workflows', 'delete workflows',
            // Users (company level)
            'view users', 'create users', 'update users', 'delete users',
            // Companies (platform level)
            'view companies', 'create companies', 'update companies', 'delete companies',
            // Plans & Subscriptions (platform level)
            'view plans', 'create plans', 'update plans', 'delete plans',
            'view subscriptions', 'create subscriptions', 'update subscriptions', 'delete subscriptions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'super_admin',
            'platform_admin',
            'company_admin',
            'designer',
            'measurer',
            'installer',
            'accountant',
            'manager',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Assign all permissions to super_admin and platform_admin
        $superAdmin    = Role::where('name', 'super_admin')->first();
        $platformAdmin = Role::where('name', 'platform_admin')->first();

        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }

        if ($platformAdmin) {
            $platformAdmin->syncPermissions(Permission::all());
        }

        // Company Admin: full access to campaign-related models, plus user management within company
        $companyAdmin = Role::where('name', 'company_admin')->first();
        if ($companyAdmin) {
            $companyAdmin->givePermissionTo([
                'view campaigns', 'create campaigns', 'update campaigns', 'delete campaigns',
                'view campaign_items', 'create campaign_items', 'update campaign_items', 'delete campaign_items',
                'view design_jobs', 'create design_jobs', 'update design_jobs', 'delete design_jobs',
                'view issues', 'create issues', 'update issues', 'delete issues',
                'view measurement_assets', 'create measurement_assets', 'update measurement_assets', 'delete measurement_assets',
                'view workflows', 'create workflows', 'update workflows', 'delete workflows',
                'view users', 'create users', 'update users', // but not delete users (company admins cannot delete users)
            ]);
        }

        // Designer: can view campaigns, create/update design jobs, view issues
        $designer = Role::where('name', 'designer')->first();
        if ($designer) {
            $designer->givePermissionTo([
                'view campaigns',
                'view design_jobs', 'create design_jobs', 'update design_jobs',
                'view issues',
                'view measurement_assets', // perhaps needed for reference
            ]);
        }

        // Measurer
        $measurer = Role::where('name', 'measurer')->first();
        if ($measurer) {
            $measurer->givePermissionTo([
                'view campaigns',
                'view campaign_items',
                'update campaign_items',
                'create measurement_assets',
                'view measurement_assets',
            ]);
        }

        // Installer
        $installer = Role::where('name', 'installer')->first();
        if ($installer) {
            $installer->givePermissionTo([
                'view campaigns',
                'view campaign_items',
                'update campaign_items',
                'create measurement_assets',
                'view measurement_assets',
            ]);
        }

        // Accountant: can view campaigns (for financial reporting) and subscriptions
        $accountant = Role::where('name', 'accountant')->first();
        if ($accountant) {
            $accountant->givePermissionTo([
                'view campaigns',
                'view subscriptions',
            ]);
        }

        // Manager: can view all campaign-related data, create/update campaigns, but not delete
        $manager = Role::where('name', 'manager')->first();
        if ($manager) {
            $manager->givePermissionTo([
                'view campaigns', 'create campaigns', 'update campaigns',
                'view campaign_items', 'create campaign_items', 'update campaign_items',
                'view design_jobs', 'create design_jobs', 'update design_jobs',
                'view issues', 'create issues', 'update issues',
                'view measurement_assets', 'create measurement_assets', 'update measurement_assets',
                'view workflows', 'create workflows', 'update workflows',
                'view users', // view only
            ]);
        }
    }
}
