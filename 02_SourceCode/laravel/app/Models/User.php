<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'locked_at' => 'datetime',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    public function favoriteArtifacts(): BelongsToMany
    {
        return $this->belongsToMany(
            Artifact::class,
            'favorite_artifacts'
        )->withTimestamps();
    }

    public function favoriteTours(): BelongsToMany
    {
        return $this->belongsToMany(
            Tour::class,
            'favorite_tours'
        )->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function guestbookEntries(): HasMany
    {
        return $this->hasMany(GuestbookEntry::class);
    }

    public function mediaAssets(): HasMany
    {
        return $this->hasMany(MediaAsset::class, 'created_by');
    }

    public function artifactsCreated(): HasMany
    {
        return $this->hasMany(Artifact::class, 'created_by');
    }

    public function toursCreated(): HasMany
    {
        return $this->hasMany(Tour::class, 'created_by');
    }

    public function visitSessions(): HasMany
    {
        return $this->hasMany(VisitSession::class);
    }
}
