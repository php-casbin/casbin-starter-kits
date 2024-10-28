<?php

namespace App\Models;

use App\Helpers\TreeListHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children')
            ->orderBy('order');
    }

    public static function getTreeListForOption(User $user, int $mode = 3): array
    {
        $selectedFields = ['id', 'title', 'parent_id', 'order'];
        $query = self::query()
            ->select($selectedFields)
            ->orderBy('order')
            ->with('children');
        if ($mode === 3) {
            $query->where([['type', 0], ['parent_id', null], ['disabled', false]]);
        } else {
            $query->where([['type', 0], ['parent_id', null]]);
        }

        $items = $query->get()->toArray();
        return TreeListHelper::filterFields($items, $selectedFields);
    }

    public static function getTreeListForRoute(User $user): array
    {
        $selectedFields = ['id', 'title', 'identifier', 'path', 'parent_id', 'order', 'type', 'hidden'];
        if ($user->isSuperAdmin()) {
            $query = self::query()
                ->select($selectedFields)
                ->where([['type', 0], ['parent_id', null], ['disabled', false]])
                ->orderBy('order')
                ->with('children');
            return TreeListHelper::filterFields($query->get()->toArray(), $selectedFields);
        }
        $items = [];
        $user->roles()->each(function ($role) use ($selectedFields, &$items) {
            $items = array_merge($items, $role->menuItems()
                ->toQuery()
                ->select($selectedFields)
                ->where([['disabled', false]])
                ->orderBy('order')
                ->get()
                ->toArray());
        });
        return self::buildTreeList($items);
    }

    private static function buildTreeList(array $menuItems, int $parentId = null): array
    {
        $result = [];
        foreach ($menuItems as $menuItem) {
            if ($menuItem['parent_id'] === $parentId) {
                $menuItem['children'] = self::buildTreeList($menuItems, $menuItem['id']);
                $result[] = $menuItem;
            } elseif (is_null($parentId) && is_null($menuItem['parent_id'])) {
                $menuItem['children'] = self::buildTreeList($menuItems, $menuItem['id']);
                $result[] = $menuItem;
            }
        }
        return $result;
    }
}
