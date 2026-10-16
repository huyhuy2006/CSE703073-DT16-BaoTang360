<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'viewpoint_id',
        'sequence_no',
        'title_override',
        'guidance_text',
        'estimated_duration_minutes',
        'is_required',
    ];

    protected function casts(): array
    {
        return [
            'sequence_no' => 'integer',
            'estimated_duration_minutes' => 'integer',
            'is_required' => 'boolean',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function viewpoint(): BelongsTo
    {
        return $this->belongsTo(Viewpoint::class);
    }

    public function narrations(): HasMany
    {
        return $this->hasMany(Narration::class);
    }

    public function visitSessionStops(): HasMany
    {
        return $this->hasMany(VisitSessionStop::class);
    }
}
