<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lauthz\Facades\Enforcer;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier'
    ];

    public function attachMenuItem(MenuItem $menuItem): void
    {
        if (is_null($menuItem->identifier)) {
            return;
        }
        Enforcer::addPermissionForUser($this->identifier, $menuItem->identifier, 'own');
    }

    public function users(): Collection
    {
        $userIds = Enforcer::getUsersForRole($this->identifier);
        return User::query()->whereIn('id', $userIds)->get();
    }

    public function menuItems(): Collection
    {
        $menuIds = Enforcer::getPermissionsForUser($this->identifier);
        $menuIds = array_column($menuIds, 1);
        return MenuItem::query()->whereIn('identifier', $menuIds)->get();
    }

    public static function getList(Request $request): array
    {
        $selectedFields = ['id', 'name', 'identifier', 'is_super_admin', 'order', 'created_at'];
        $query = self::query()
            ->select($selectedFields)
            ->orderBy('order')
            ->withCasts(['created_at' => 'date:Y-m-d H:i:s']);
        if ($request->input('q')) {
            $query->where('name', 'like', "%{$request->input('q')}%");
        }
        $paginate = $query->paginate(10);
        return [
            'data' => $paginate->items(),
            'current_page' => $paginate->currentPage(),
            'per_page' => $paginate->perPage(),
            'total' => $paginate->total(),
            'last_page' => $paginate->lastPage(),
            'prev_page_url' => $paginate->previousPageUrl(),
            'next_page_url' => $paginate->nextPageUrl(),
        ];
    }

    public static function getFilter(): array
    {
        $roles = Role::all(['id as value', 'name', 'identifier'])->slice(0, 10);
        foreach ($roles as &$role) {
            $role['count'] = $role->users()->count();
        }
        return $roles->toArray();
    }
}
