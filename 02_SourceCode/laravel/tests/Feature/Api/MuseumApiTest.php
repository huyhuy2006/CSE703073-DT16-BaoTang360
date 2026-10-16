<?php

namespace Tests\Feature\Api;

use App\Models\Museum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuseumApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_returns_only_published_museums(): void
    {
        Museum::query()->create([
            'slug' => 'museum-published',
            'name' => 'Museum Published',
            'institution' => 'Published Institution',
            'country_code' => 'VN',
            'is_published' => true,
        ]);

        Museum::query()->create([
            'slug' => 'museum-draft',
            'name' => 'Museum Draft',
            'institution' => 'Draft Institution',
            'country_code' => 'VN',
            'is_published' => false,
        ]);

        $this->getJson('/api/v1/museums')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath(
                'data.0.slug',
                'museum-published'
            );
    }

    public function test_search_filters_by_name_or_institution(): void
    {
        Museum::query()->create([
            'slug' => 'naturalis-demo',
            'name' => 'Naturalis Demo',
            'institution' => 'Naturalis',
            'is_published' => true,
        ]);

        Museum::query()->create([
            'slug' => 'other-museum',
            'name' => 'Other Museum',
            'institution' => 'Other Institution',
            'is_published' => true,
        ]);

        $this->getJson('/api/v1/museums?q=Naturalis')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath(
                'data.0.slug',
                'naturalis-demo'
            );
    }

    public function test_invalid_per_page_returns_validation_error(): void
    {
        $this->getJson('/api/v1/museums?per_page=1000')
            ->assertUnprocessable();
    }

    public function test_published_museum_can_be_viewed_by_slug(): void
    {
        Museum::query()->create([
            'slug' => 'museum-detail',
            'name' => 'Museum Detail',
            'institution' => 'Example Institution',
            'is_published' => true,
        ]);

        $this->getJson('/api/v1/museums/museum-detail')
            ->assertOk()
            ->assertJsonPath('data.slug', 'museum-detail');
    }

    public function test_unpublished_museum_is_not_publicly_visible(): void
    {
        Museum::query()->create([
            'slug' => 'museum-hidden',
            'name' => 'Museum Hidden',
            'institution' => 'Hidden Institution',
            'is_published' => false,
        ]);

        $this->getJson('/api/v1/museums/museum-hidden')
            ->assertNotFound();
    }
}
