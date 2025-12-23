<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('query_teams')->onDelete('cascade');
            $table->date('metric_date'); // Date for daily metrics
            $table->integer('total_queries')->default(0);
            $table->integer('pending_queries')->default(0);
            $table->integer('in_progress_queries')->default(0);
            $table->integer('resolved_queries')->default(0);
            $table->integer('avg_response_hours')->nullable(); // Average hours to first response
            $table->integer('avg_resolution_hours')->nullable(); // Average hours to resolution
            $table->timestamps();
            
            // Unique constraint for team-date combination
            $table->unique(['team_id', 'metric_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_performance_metrics');
    }
};