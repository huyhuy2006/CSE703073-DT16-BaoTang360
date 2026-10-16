<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_artifacts', function (Blueprint $table): void {
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('artifact_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->primary(['user_id', 'artifact_id']);
        });

        Schema::create('favorite_tours', function (Blueprint $table): void {
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->primary(['user_id', 'tour_id']);
        });

        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('artifact_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tour_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('content');
            $table->string('moderation_status', 30)
                ->default('pending');

            $table->timestamps();

            $table->index(['moderation_status', 'created_at']);
            $table->index('artifact_id');
            $table->index('tour_id');
        });

        Schema::create('guestbook_entries', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('display_name', 150)->nullable();
            $table->text('message');

            $table->string('moderation_status', 30)
                ->default('pending');

            $table->timestamps();

            $table->index(['moderation_status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('guestbook_entries');
        Schema::dropIfExists('favorite_tours');
        Schema::dropIfExists('favorite_artifacts');
    }
};
