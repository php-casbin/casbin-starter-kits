<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Lauthz\Facades\Enforcer;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        // 'profile_photo_path',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAuthIdentifier(): string
    {
        return $this->id ?? '';
    }

    public function attachRole(Role $role): void
    {
        Enforcer::addRoleForUser($this->getAuthIdentifier(), $role->identifier);
    }

    public function attachRoles(array $roles): void
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    public function detachRole(Role $role): void
    {
        Enforcer::deleteRoleForUser($this->getAuthIdentifier(), $role->identifier);
    }

    public function detachRoles(array $roles): void
    {
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }

    public function detachAllRoles(): void
    {
        Enforcer::deleteRolesForUser($this->getAuthIdentifier());
    }

    public function attachOrganization(Organization $organization): void
    {
        $this->organizations()->attach($organization);
    }

    public function detachOrganization(Organization $organization): void
    {
        $this->organizations()->detach($organization);
    }

    public function roles(): Collection
    {
        $roleIds = Enforcer::getRolesForUser($this->getAuthIdentifier());
        return Role::query()->whereIn('identifier', $roleIds)->get();
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()->contains('is_super_admin', true);
    }

    public static function getList(Request $request): array
    {
        $selectedFields = ['id', 'name', 'email', 'profile_photo_path', 'created_at'];
        $query = self::query()
            ->select($selectedFields)
            ->withCasts(['created_at' => 'date:Y-m-d H:i:s'])
            ->with('organizations:id,name');
        $roleFilter = $request->input('role');
        if ($roleFilter) {
            // slow
            $userIds = Enforcer::getUsersForRole(Role::query()->where('id', $roleFilter)->first()->identifier);
            $query->whereIn('id', $userIds);
        }
        if ($request->input('q')) {
            $query->where('name', 'like', "%{$request->input('q')}%");
        }
        $paginate = $query->paginate(10);
        $items = $paginate->items();
        foreach ($items as &$item) {
            $item['roles'] = $item->roles()->select(['id', 'name'])->all();
        }
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
}
