<?php

namespace Tests\Unit;

use App\Models\MenuItem;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function testGetTreeList()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $rootMenuItem = MenuItem::factory()->create([
            'title' => 'root',
            'parent_id' => null
        ]);
        $role->attachMenuItem($rootMenuItem);

        $childMenuItem2 = MenuItem::factory()->create([
            'title' => 'child2',
            'parent_id' => $rootMenuItem->id,
            'type' => 1,
            'order' => 1
        ]);
        $role->attachMenuItem($childMenuItem2);

        $childMenuItem1 = MenuItem::factory()->create([
            'title' => 'child1',
            'parent_id' => $rootMenuItem->id,
            'type' => 1,
            'order' => 0
        ]);
        $role->attachMenuItem($childMenuItem1);

        $grandchildMenuItem1 = MenuItem::factory()->create([
            'title' => 'grandchild1',
            'parent_id' => $childMenuItem1->id,
            'type' => 2
        ]);
        $role->attachMenuItem($grandchildMenuItem1);

        $user->attachRole($role);

        $tree = MenuItem::getTreeListForRoute($user);
        $this->assertEquals($rootMenuItem->id, $tree[0]['id']);
        $this->assertEquals($childMenuItem1->id, $tree[0]['children'][0]['id']);
        $this->assertEquals($grandchildMenuItem1->id, $tree[0]['children'][0]['children'][0]['id']);
    }
}
