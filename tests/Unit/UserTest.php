<?php

namespace Tests\Unit;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetRelations()
    {
        // organization
        $user = User::factory()
            ->has(Organization::factory()->count(2))
            ->create();
        $this->assertEquals(2, $user->organizations->count());

        $organization = Organization::factory()
            ->has(User::factory()->count(5))
            ->create();
        $this->assertEquals(5, $organization->users->count());

        // roles
        $user = User::factory()->create();
        $roles = Role::factory()->count(5)->create();
        $roles->each(fn ($role) => $user->attachRole($role));
        $this->assertEquals(5, $user->roles()->count());

        $role = Role::factory()->create();
        $users = User::factory()->count(5)->create();
        $users->each(fn ($user) => $user->attachRole($role));
        $this->assertEquals(5, $role->users()->count());
    }
}
