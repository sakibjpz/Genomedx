<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_features', function (Blueprint $table) {
            $table->string('download_link')->nullable()->after('description');
            $table->string('download_label')->nullable()->after('download_link')->default('Download Laboratory Workflow');
        });
    }

    public function down(): void
    {
        Schema::table('product_features', function (Blueprint $table) {
            $table->dropColumn(['download_link', 'download_label']);
        });
    }
};