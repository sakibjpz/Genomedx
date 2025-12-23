<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('query_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_query_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['email', 'phone', 'message', 'internal_note']);
            $table->text('content');
            $table->boolean('customer_notified')->default(true);
            $table->timestamp('responded_at')->useCurrent();
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['contact_query_id', 'responded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('query_responses');
    }
};