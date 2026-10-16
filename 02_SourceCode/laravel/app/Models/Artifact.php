<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'museum_id',
        'slug',
        'title',
        'origin',
        'period',
        'material',
        'description',
        'source_name',
        'source_url',
        'source_license',
        'attribution_text',
        'created_by',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function museum(): BelongsTo
    {
        return $this->belongsTo(Museum::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function mediaAssets(): BelongsToMany
    {
        return $this->belongsToMany(
            MediaAsset::class,
            'artifact_media'
        )->withPivot([
            'media_role',
            'display_order',
        ])->withTimestamps();
    }

    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class);
    }

    public function narrations(): HasMany
    {
        return $this->hasMany(Narration::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(
            User::class,
            'favorite_artifacts'
        )->withTimestamps();
    }
}
