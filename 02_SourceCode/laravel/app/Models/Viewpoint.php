<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Viewpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'space_id',
        'slug',
        'title',
        'description',
        'panorama_asset_id',
        'tile_manifest_asset_id',
        'rendering_mode',
        'initial_yaw_deg',
        'initial_pitch_deg',
        'mini_map_x_norm',
        'mini_map_y_norm',
        'is_entry_point',
        'display_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'initial_yaw_deg' => 'float',
            'initial_pitch_deg' => 'float',
            'mini_map_x_norm' => 'float',
            'mini_map_y_norm' => 'float',
            'is_entry_point' => 'boolean',
            'display_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function space(): BelongsTo
    {
        return $this->belongsTo(Space::class);
    }

    public function panoramaAsset(): BelongsTo
    {
        return $this->belongsTo(
            MediaAsset::class,
            'panorama_asset_id'
        );
    }

    public function tileManifestAsset(): BelongsTo
    {
        return $this->belongsTo(
            MediaAsset::class,
            'tile_manifest_asset_id'
        );
    }

    public function outgoingGateways(): HasMany
    {
        return $this->hasMany(
            Gateway::class,
            'from_viewpoint_id'
        );
    }

    public function incomingGateways(): HasMany
    {
        return $this->hasMany(
            Gateway::class,
            'to_viewpoint_id'
        );
    }

    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class);
    }

    public function tourStops(): HasMany
    {
        return $this->hasMany(TourStop::class);
    }

    public function narrations(): HasMany
    {
        return $this->hasMany(Narration::class);
    }
}
