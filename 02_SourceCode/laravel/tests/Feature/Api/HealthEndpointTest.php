<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class HealthEndpointTest extends TestCase
{
    public function test_health_endpoint_returns_successful_json(): void
    {
        $this->getJson('/api/v1/health')
            ->assertOk()
            ->assertExactJson([
                'status' => 'ok',
                'service' => 'dt16-backend',
                'version' => '0.1.0',
            ]);
    }

    public function test_database_health_endpoint_can_execute_a_query(): void
    {
        $this->getJson('/api/v1/health/database')
            ->assertOk()
            ->assertJsonPath('status', 'ok')
            ->assertJsonPath('database', 'available');
    }
}
