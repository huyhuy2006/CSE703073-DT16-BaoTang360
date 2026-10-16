<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DatabaseHealthController
{
    public function __invoke(): JsonResponse
    {
        try {
            DB::select('SELECT 1');

            return response()->json([
                'status' => 'ok',
                'database' => 'available',
            ]);
        } catch (Throwable $exception) {
            Log::warning('DT-16 database health check failed.', [
                'exception_class' => $exception::class,
            ]);

            return response()->json([
                'status' => 'error',
                'database' => 'unavailable',
            ], 503);
        }
    }
}
