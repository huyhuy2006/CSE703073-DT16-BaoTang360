<?php

use App\Http\Controllers\Api\V1\DatabaseHealthController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\MuseumController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    // Kiểm tra ứng dụng.
    Route::get('/health', HealthController::class)
        ->name('api.v1.health');

    // Kiểm tra kết nối database.
    Route::get('/health/database', DatabaseHealthController::class)
        ->name('api.v1.health.database');

    // Danh sách bảo tàng đã xuất bản.
    Route::get('/museums', [MuseumController::class, 'index'])
        ->name('api.v1.museums.index');

    // Chi tiết bảo tàng theo slug.
    Route::get('/museums/{museumSlug}', [MuseumController::class, 'show'])
        ->where('museumSlug', '[A-Za-z0-9-]+')
        ->name('api.v1.museums.show');
});
