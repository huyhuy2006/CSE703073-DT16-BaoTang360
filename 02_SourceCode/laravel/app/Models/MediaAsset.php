<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_type',
        'disk',
        'storage_path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'width_px',
        'height_px',
        'duration_ms',
        'language_code',
        'alt_text',
        'license_name',
        'source_url',
        'attribution_text',
        'checksum_sha256',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
            'width_px' => 'integer',
            'height_px' => 'integer',
            'duration_ms' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function panoramaViewpoints(): HasMany
    {
        return $this->hasMany(
            Viewpoint::class,
            'panorama_asset_id'
        );
    }

    public function tileManifestViewpoints(): HasMany
    {
        return $this->hasMany(
            Viewpoint::class,
            'tile_manifest_asset_id'
        );
    }

    public function artifacts(): BelongsToMany
    {
        return $this->belongsToMany(
            Artifact::class,
            'artifact_media'
        )->withPivot([
            'media_role',
            'display_order',
        ])->withTimestamps();
    }
}
