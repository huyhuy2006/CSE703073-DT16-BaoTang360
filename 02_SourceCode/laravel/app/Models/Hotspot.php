<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewpoint_id',
        'artifact_id',
        'title',
        'description',
        'hotspot_type',
        'yaw_deg',
        'pitch_deg',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'yaw_deg' => 'float',
            'pitch_deg' => 'float',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function viewpoint(): BelongsTo
    {
        return $this->belongsTo(Viewpoint::class);
    }

    public function artifact(): BelongsTo
    {
        return $this->belongsTo(Artifact::class);
    }
}
