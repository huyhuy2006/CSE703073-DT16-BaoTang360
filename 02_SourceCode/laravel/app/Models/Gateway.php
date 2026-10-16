<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_viewpoint_id',
        'to_viewpoint_id',
        'label',
        'yaw_deg',
        'pitch_deg',
        'target_yaw_deg',
        'target_pitch_deg',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'yaw_deg' => 'float',
            'pitch_deg' => 'float',
            'target_yaw_deg' => 'float',
            'target_pitch_deg' => 'float',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function fromViewpoint(): BelongsTo
    {
        return $this->belongsTo(
            Viewpoint::class,
            'from_viewpoint_id'
        );
    }

    public function toViewpoint(): BelongsTo
    {
        return $this->belongsTo(
            Viewpoint::class,
            'to_viewpoint_id'
        );
    }
}
