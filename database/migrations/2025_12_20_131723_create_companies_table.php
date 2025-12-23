<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    if (!Schema::hasTable('companies')) {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    // Add company_id to product_groups table if not exists
    if (!Schema::hasColumn('product_groups', 'company_id')) {
        Schema::table('product_groups', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('slug')->constrained()->onDelete('set null');
            $table->index('company_id');
        });
    }
}

public function down(): void
{
    // Don't drop anything in rollback to be safe
    // Schema::table('product_groups', function (Blueprint $table) {
    //     $table->dropForeign(['company_id']);
    //     $table->dropColumn('company_id');
    // });
    
    // Schema::dropIfExists('companies');
}
};