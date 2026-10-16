<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'museum_id',
        'parent_space_id',
        'slug',
        'name',
        'description',
        'display_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function museum(): BelongsTo
    {
        return $this->belongsTo(Museum::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            Space::class,
            'parent_space_id'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            Space::class,
            'parent_space_id'
        );
    }

    public function viewpoints(): HasMany
    {
        return $this->hasMany(Viewpoint::class);
    }
}
