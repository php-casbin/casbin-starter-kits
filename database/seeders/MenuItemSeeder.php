<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuParent = MenuItem::query()->firstOrCreate([
            'title' => 'Dashboard',
            'identifier' => 'dashboard',
        ]);

        $menuItem = MenuItem::query()->firstOrNew([
            'title' => 'Workspace'
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'identifier' => 'dashboard.workspace',
                'type' => 1,
                'parent_id' => $menuParent->id
            ])->save();
        }

        $menuParent = MenuItem::query()->firstOrCreate([
            'title' => 'Permission',
            'identifier' => 'permission',
        ]);

        $menuItem = MenuItem::query()->firstOrNew([
            'title' => 'Organization'
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'identifier' => 'organizations.index',
                'type' => 1,
                'parent_id' => $menuParent->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Organization List']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'organizations.index',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Create Organization']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'organizations.store',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Update Organization']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'organizations.update',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Delete Organization']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'organizations.destroy',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $menuItem = MenuItem::query()->firstOrNew([
            'title' => 'Menu'
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'identifier' => 'menus.index',
                'type' => 1,
                'parent_id' => $menuParent->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Menu List']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'menus.index',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Create Menu']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'menus.store',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Update Menu']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'menus.update',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Delete Menu']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'menus.destroy',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $menuItem = MenuItem::query()->firstOrNew([
            'title' => 'Role'
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'identifier' => 'roles.index',
                'type' => 1,
                'parent_id' => $menuParent->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Role List']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'roles.index',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Create Role']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'roles.store',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Update Role']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'roles.update',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Delete Role']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'roles.destroy',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $menuItem = MenuItem::query()->firstOrNew([
            'title' => 'User'
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'identifier' => 'users.index',
                'type' => 1,
                'parent_id' => $menuParent->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'User List']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'users.index',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Create User']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'users.store',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Update User']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'users.update',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }

        $permission = MenuItem::query()->firstOrNew(['title' => 'Delete User']);
        if (!$permission->exists) {
            $permission->fill([
                'identifier' => 'users.destroy',
                'type' => 2,
                'parent_id' => $menuItem->id
            ])->save();
        }
    }
}
