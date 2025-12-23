<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('category'); // 'product_leaflet', 'eqa_results', 'documentation', 'brochure'
            $table->string('title'); // Display name like "Product Leaflet", "EQA Results 2023"
            $table->string('file_path'); // Storage path
            $table->string('file_name'); // Original file name
            $table->string('file_size')->nullable(); // e.g., "2.5 MB"
            $table->string('file_type')->nullable(); // 'pdf', 'doc', 'xlsx'
            $table->integer('download_count')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['product_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_documents');
    }
};