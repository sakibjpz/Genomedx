<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('product_groups', function (Blueprint $table) {
    $table->id();

    $table->string('name');
    $table->string('slug')->unique();

    // UI related
    $table->string('color')->nullable(); // red, green, hex, tailwind class
    $table->string('icon')->nullable();  // svg name or icon key

    $table->integer('position')->default(0);
    $table->boolean('status')->default(true);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_groups');
    }
};
