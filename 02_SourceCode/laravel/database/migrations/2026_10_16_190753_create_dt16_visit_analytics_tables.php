<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_sessions', function (Blueprint $table): void {
            $table->id();

            $table->uuid('public_id')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('tour_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('visit_mode', 30);
            $table->string('status', 30)->default('active');

            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();

            $table->foreignId('last_viewpoint_id')
                ->nullable()
                ->constrained('viewpoints')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'last_activity_at']);
            $table->index(['tour_id', 'started_at']);
        });

        Schema::create(
            'visit_session_stops',
            function (Blueprint $table): void {
                $table->id();

                $table->foreignId('visit_session_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('tour_stop_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('status', 30)
                    ->default('not_started');

                $table->timestamp('entered_at')->nullable();
                $table->timestamp('completed_at')->nullable();

                $table->timestamps();

                $table->unique([
                    'visit_session_id',
                    'tour_stop_id',
                ]);
            }
        );

        Schema::create('visit_events', function (Blueprint $table): void {
            $table->id();

            $table->uuid('client_event_id')->nullable()->unique();

            $table->foreignId('visit_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('event_type', 80);

            $table->foreignId('viewpoint_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('artifact_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('tour_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->json('event_data')->nullable();
            $table->timestamp('occurred_at');

            $table->timestamps();

            $table->index(['event_type', 'occurred_at']);
            $table->index([
                'visit_session_id',
                'occurred_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_events');
        Schema::dropIfExists('visit_session_stops');
        Schema::dropIfExists('visit_sessions');
    }
};
