<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'museum_id',
        'slug',
        'title',
        'theme',
        'description',
        'estimated_duration_minutes',
        'cover_media_asset_id',
        'created_by',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'estimated_duration_minutes' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function museum(): BelongsTo
    {
        return $this->belongsTo(Museum::class);
    }

    public function coverMediaAsset(): BelongsTo
    {
        return $this->belongsTo(
            MediaAsset::class,
            'cover_media_asset_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function stops(): HasMany
    {
        return $this->hasMany(TourStop::class)
            ->orderBy('sequence_no');
    }

    public function narrations(): HasMany
    {
        return $this->hasManyThrough(
            Narration::class,
            TourStop::class
        );
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'favorite_tours'
        )->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function visitSessions(): HasMany
    {
        return $this->hasMany(VisitSession::class);
    }
}
