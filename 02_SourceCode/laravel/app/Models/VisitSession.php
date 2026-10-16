<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_id',
        'user_id',
        'tour_id',
        'visit_mode',
        'status',
        'started_at',
        'ended_at',
        'last_activity_at',
        'last_viewpoint_id',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function lastViewpoint(): BelongsTo
    {
        return $this->belongsTo(
            Viewpoint::class,
            'last_viewpoint_id'
        );
    }

    public function stops(): HasMany
    {
        return $this->hasMany(VisitSessionStop::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(VisitEvent::class);
    }
}
