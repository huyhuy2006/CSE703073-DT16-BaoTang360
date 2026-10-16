<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitSessionStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_session_id',
        'tour_stop_id',
        'status',
        'entered_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'entered_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function visitSession(): BelongsTo
    {
        return $this->belongsTo(VisitSession::class);
    }

    public function tourStop(): BelongsTo
    {
        return $this->belongsTo(TourStop::class);
    }
}
