<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table): void {
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('role_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['user_id', 'role_id']);
            $table->timestamps();
        });

        Schema::create('museums', function (Blueprint $table): void {
            $table->id();
            $table->string('slug', 160);
            $table->string('name', 255);
            $table->string('institution', 255)->nullable();
            $table->char('country_code', 2)->nullable();
            $table->text('description')->nullable();
            $table->string('official_url', 2048)->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['slug']);
            $table->index(['is_published', 'name']);
        });

        Schema::create('media_assets', function (Blueprint $table): void {
            $table->id();
            $table->string('media_type', 30);
            $table->string('disk', 50);
            $table->string('storage_path', 2048);
            $table->string('original_filename', 255)->nullable();
            $table->string('mime_type', 150);
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->unsignedInteger('width_px')->nullable();
            $table->unsignedInteger('height_px')->nullable();
            $table->unsignedBigInteger('duration_ms')->nullable();
            $table->string('language_code', 10)->nullable();
            $table->string('alt_text', 500)->nullable();
            $table->string('license_name', 255)->nullable();
            $table->string('source_url', 2048)->nullable();
            $table->text('attribution_text')->nullable();
            $table->char('checksum_sha256', 64)->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['media_type', 'created_at']);
        });

        Schema::create('spaces', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('museum_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('parent_space_id')
                ->nullable()
                ->constrained('spaces')
                ->nullOnDelete();

            $table->string('slug', 160);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['museum_id', 'slug']);
            $table->index(['museum_id', 'is_published']);
        });

        Schema::create('artifacts', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('museum_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('slug', 180);
            $table->string('title', 255);
            $table->string('origin', 255)->nullable();
            $table->string('period', 255)->nullable();
            $table->string('material', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('source_name', 255)->nullable();
            $table->string('source_url', 2048)->nullable();
            $table->string('source_license', 255)->nullable();
            $table->text('attribution_text')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['museum_id', 'slug']);
            $table->index(['museum_id', 'is_published']);
            $table->index('title');
        });

        Schema::create('viewpoints', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('space_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('slug', 160);
            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->foreignId('panorama_asset_id')
                ->constrained('media_assets')
                ->restrictOnDelete();

            $table->foreignId('tile_manifest_asset_id')
                ->nullable()
                ->constrained('media_assets')
                ->nullOnDelete();

            $table->string('rendering_mode', 30)
                ->default('equirectangular');

            $table->decimal('initial_yaw_deg', 8, 4)->default(0);
            $table->decimal('initial_pitch_deg', 8, 4)->default(0);

            $table->decimal('mini_map_x_norm', 8, 6)->nullable();
            $table->decimal('mini_map_y_norm', 8, 6)->nullable();

            $table->boolean('is_entry_point')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['space_id', 'slug']);
            $table->index(['space_id', 'is_published']);
        });

        Schema::create('gateways', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('from_viewpoint_id')
                ->constrained('viewpoints')
                ->cascadeOnDelete();

            $table->foreignId('to_viewpoint_id')
                ->constrained('viewpoints')
                ->cascadeOnDelete();

            $table->string('label', 150);
            $table->decimal('yaw_deg', 8, 4);
            $table->decimal('pitch_deg', 8, 4);

            $table->decimal('target_yaw_deg', 8, 4)->nullable();
            $table->decimal('target_pitch_deg', 8, 4)->nullable();

            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['from_viewpoint_id', 'is_active']);
            $table->index('to_viewpoint_id');
        });

        Schema::create('artifact_media', function (Blueprint $table): void {
            $table->foreignId('artifact_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('media_asset_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('media_role', 30)->default('gallery');
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->primary(['artifact_id', 'media_asset_id']);
        });

        Schema::create('hotspots', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('viewpoint_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('artifact_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('hotspot_type', 30);

            $table->decimal('yaw_deg', 8, 4);
            $table->decimal('pitch_deg', 8, 4);

            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['viewpoint_id', 'is_active']);
            $table->index('artifact_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspots');
        Schema::dropIfExists('artifact_media');
        Schema::dropIfExists('gateways');
        Schema::dropIfExists('viewpoints');
        Schema::dropIfExists('artifacts');
        Schema::dropIfExists('spaces');
        Schema::dropIfExists('media_assets');
        Schema::dropIfExists('museums');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
