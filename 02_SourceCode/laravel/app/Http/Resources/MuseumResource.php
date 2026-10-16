<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MuseumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'institution' => $this->institution,
            'country_code' => $this->country_code,
            'description' => $this->description,
            'official_url' => $this->official_url,
        ];
    }
}
