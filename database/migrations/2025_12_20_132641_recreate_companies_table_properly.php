<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing companies table (empty anyway)
        Schema::dropIfExists('companies');
        
        // Remove company_id from product_groups
        Schema::table('product_groups', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        // Create fresh companies table
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Add company_id back to product_groups (without problematic index)
        Schema::table('product_groups', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('slug')->constrained()->onDelete('set null');
            // Only index company_id, not is_active
            $table->index('company_id');
        });
    }

    public function down(): void
    {
        Schema::table('product_groups', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
        
        Schema::dropIfExists('companies');
    }
};