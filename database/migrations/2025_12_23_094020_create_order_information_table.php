<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_information', function (Blueprint $table) {
            $table->id();
            $table->string('sales_phone')->nullable();
            $table->string('sales_email')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('support_hours')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_website')->nullable();
            $table->string('contact_button_text')->default('Request Quote / Contact');
            $table->string('contact_button_link')->default('/contact');
            $table->boolean('show_sales_section')->default(true);
            $table->boolean('show_support_section')->default(true);
            $table->boolean('show_address_section')->default(true);
            $table->timestamps();
        });
        
        // Insert default data
        DB::table('order_information')->insert([
            'sales_phone' => '+880 2966 4349',
            'sales_email' => 'genomedxcorporation@gmail.com',
            'support_phone' => 'Available 9 AM - 6 PM',
            'support_hours' => 'Sunday - Thursday',
            'company_address' => "205/1 (1st Floor)\nDr. Kudrat-E-Khuda Road\nDhaka-1205, Bangladesh",
            'company_website' => 'https://www.genomedxbd.com',
            'contact_button_text' => 'Request Quote / Contact',
            'contact_button_link' => '/contact',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('order_information');
    }
};