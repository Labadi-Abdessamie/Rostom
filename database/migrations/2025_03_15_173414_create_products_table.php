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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_description');
            $table->text('long_description')->nullable();
            $table->unsignedInteger('actual_quantity');
            $table->float('price');
            $table->string('principalImage')->nullable();
            $table->json('sizeVar')->nullable();
            $table->json('colorVar')->nullable();
            $table->double('rate_average')->default(0);
            $table->unsignedInteger('rate_count')->default(0);
            $table->string('category_id');
            $table->string('magasin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
