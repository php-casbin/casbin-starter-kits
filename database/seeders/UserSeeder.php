<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::query()->count() === 0){
            $role = Role::query()->firstOrCreate(['name' => 'admin', 'identifier' => 'admin']);
            $organization = Organization::query()->firstOrCreate(['name' => 'default', 'identifier' => 'default'])
;
            $user = User::query()->create([
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => 'admin'
            ]);

            $user->attachRole($role);
            $user->attachOrganization($organization);

            $role = Role::query()->firstOrCreate(['name' => 'user', 'identifier' => 'user']);
            $user = User::query()->create([
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => 'user'
            ]);
            $user->attachRole($role);
        }
    }
}

