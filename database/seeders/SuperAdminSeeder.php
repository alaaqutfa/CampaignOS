<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@alaaqutfa.tech'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('A123456a@'),
                'is_super_admin' => true,
            ]
        );

        $user->assignRole('super_admin');
    }
}
