<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Museum extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'institution',
        'country_code',
        'description',
        'official_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function spaces(): HasMany
    {
        return $this->hasMany(Space::class);
    }

    public function artifacts(): HasMany
    {
        return $this->hasMany(Artifact::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
