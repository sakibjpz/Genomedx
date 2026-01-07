<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('contact_queries', function (Blueprint $table) {
        $table->string('attachment_path')->nullable()->after('message');
        $table->string('attachment_name')->nullable()->after('attachment_path');
    });
}

public function down()
{
    Schema::table('contact_queries', function (Blueprint $table) {
        $table->dropColumn(['attachment_path', 'attachment_name']);
    });
}
};
