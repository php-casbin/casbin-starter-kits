<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'identifier'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Organization::class, 'parent_id')
            ->with('children');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public static function getTreeList(): array
    {
        $selectedFields = ['id', 'name', 'identifier', 'disabled', 'order', 'created_at'];
        $paginate = self::query()
            ->select($selectedFields)
            ->where([['parent_id', null]])
            ->orderBy('order')
            ->withCasts(['created_at' => 'date:Y-m-d H:i:s'])
            ->with('children')
            ->paginate(10);
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
