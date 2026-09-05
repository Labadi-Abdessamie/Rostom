<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_infos', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('e.g. total_vendors, total_products, total_members, total_countries');
            $table->string('value')->comment('The displayed value, e.g. "12K+"');
            $table->string('label')->comment('Human-readable label, e.g. "Active Vendors"');
            $table->string('icon')->nullable()->comment('FontAwesome class, e.g. "fas fa-store"');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_infos');
    }
};
