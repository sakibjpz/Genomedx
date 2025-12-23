<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('query_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Sales, Support, Technical, etc.
            $table->string('email'); // Team notification email
            $table->json('query_types'); // Which query types this team handles
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create assignment table
        Schema::create('query_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_query_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained('query_teams')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('pending'); // pending, assigned, in_progress, resolved
            $table->text('notes')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('query_assignments');
        Schema::dropIfExists('query_teams');
    }
};