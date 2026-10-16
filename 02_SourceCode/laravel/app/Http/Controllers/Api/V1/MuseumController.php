<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ListMuseumsRequest;
use App\Http\Resources\MuseumResource;
use App\Models\Museum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MuseumController extends Controller
{
    public function index(
        ListMuseumsRequest $request
    ): AnonymousResourceCollection {
        $filters = $request->validated();

        $query = Museum::query()
            ->where('is_published', true);

        $keyword = trim((string) ($filters['q'] ?? ''));

        if ($keyword !== '') {
            $query->where(function (Builder $builder) use ($keyword): void {
                $builder
                    ->where('name', 'like', "%{$keyword}%")
                    ->orWhere('institution', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $perPage = (int) ($filters['per_page'] ?? 12);

        $museums = $query
            ->orderBy('name')
            ->paginate($perPage)
            ->appends($filters);

        return MuseumResource::collection($museums);
    }

    public function show(string $museumSlug): MuseumResource
    {
        $museum = Museum::query()
            ->where('slug', $museumSlug)
            ->where('is_published', true)
            ->firstOrFail();

        return new MuseumResource($museum);
    }
}
