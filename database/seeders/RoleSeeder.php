<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::query()->firstOrCreate(['name' => 'admin', 'identifier' => 'admin', 'is_super_admin' => true]);
        $user = Role::query()->firstOrCreate(['name' => 'user', 'identifier' => 'user']);
        $user->attachMenuItem(MenuItem::query()->where('identifier', 'dashboard')->first());
        $user->attachMenuItem(MenuItem::query()->where('identifier', 'dashboard.workspace')->first());
    }
}
