<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title'); // "HIGH SPECIFICITY", "HIGH SENSITIVITY", "WHO STANDARD BASED QUANTIFICATION"
            $table->text('description')->nullable(); // The detailed bullet point text
            $table->string('icon')->nullable(); // Optional: icon class or image path
            $table->string('color')->nullable()->default('#3b82f6'); // For styling like GeneProof
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['product_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_features');
    }
};