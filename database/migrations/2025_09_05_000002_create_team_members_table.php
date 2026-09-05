<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('department')->comment('e.g. Leadership, Engineering, Design, Operations, Support');
            $table->text('bio')->nullable();
            $table->string('image')->nullable()->comment('Storage path to profile image');
            $table->string('email')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->json('skills')->nullable()->comment('Array of skill tags');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('status')->default(true)->comment('0=hidden, 1=visible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
