<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('hero_title, hero_text, hero_caption, mission_card, team_intro_title, team_intro_text');
            $table->string('title')->nullable()->comment('Used for card titles, hero headings');
            $table->text('text')->nullable()->comment('Paragraph text, card descriptions');
            $table->string('icon')->nullable()->comment('FontAwesome class for mission cards');
            $table->string('color')->nullable()->comment('Background/color variant class');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
