<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Narration extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_code',
        'title',
        'transcript',
        'audio_asset_id',
        'artifact_id',
        'viewpoint_id',
        'tour_stop_id',
    ];

    public function audioAsset(): BelongsTo
    {
        return $this->belongsTo(
            MediaAsset::class,
            'audio_asset_id'
        );
    }

    public function artifact(): BelongsTo
    {
        return $this->belongsTo(Artifact::class);
    }

    public function viewpoint(): BelongsTo
    {
        return $this->belongsTo(Viewpoint::class);
    }

    public function tourStop(): BelongsTo
    {
        return $this->belongsTo(TourStop::class);
    }
}
