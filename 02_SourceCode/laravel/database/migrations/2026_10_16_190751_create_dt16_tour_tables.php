<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('museum_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('slug', 180);
            $table->string('title', 255);
            $table->string('theme', 150)->nullable();
            $table->text('description')->nullable();

            $table->unsignedSmallInteger(
                'estimated_duration_minutes'
            )->nullable();

            $table->foreignId('cover_media_asset_id')
                ->nullable()
                ->constrained('media_assets')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['museum_id', 'slug']);
            $table->index(['museum_id', 'is_published']);
        });

        Schema::create('tour_stops', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('viewpoint_id')
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedInteger('sequence_no');

            $table->string('title_override', 255)->nullable();
            $table->text('guidance_text')->nullable();

            $table->unsignedSmallInteger(
                'estimated_duration_minutes'
            )->nullable();

            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->unique(['tour_id', 'sequence_no']);
            $table->index('viewpoint_id');
        });

        Schema::create('narrations', function (Blueprint $table): void {
            $table->id();

            $table->string('language_code', 10);
            $table->string('title', 255)->nullable();
            $table->text('transcript')->nullable();

            $table->foreignId('audio_asset_id')
                ->constrained('media_assets')
                ->restrictOnDelete();

            $table->foreignId('artifact_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('viewpoint_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tour_stop_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index(['language_code', 'artifact_id']);
            $table->index(['language_code', 'viewpoint_id']);
            $table->index(['language_code', 'tour_stop_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('narrations');
        Schema::dropIfExists('tour_stops');
        Schema::dropIfExists('tours');
    }
};
