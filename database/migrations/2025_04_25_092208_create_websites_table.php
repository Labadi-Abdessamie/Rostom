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
        Schema::create('websites', function (Blueprint $table) {
            $table->string('url')->primary();
            $table->string('name');
            $table->string('logo');
            $table->string('favicon');
            $table->string('description');
            $table->string('owner');
            $table->string('language');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->json('social_media_links');
            $table->unsignedBigInteger('customers_number');
            $table->unsignedBigInteger('vendors_number');
            $table->unsignedBigInteger('products_number');
            $table->unsignedBigInteger('ordersDone_number');
            $table->string('rules_and_privacy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
