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
        Schema::create('magasins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phoneNumber');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('magasinPicture')->nullable();
            $table->string('vitrineVideo')->nullable();
            $table->text('bio')->nullable();
            $table->string('location');
            $table->boolean('magasinOpen')->default(0);
            $table->float('rate_average')->default(0);
            $table->unsignedInteger('rate_count')->default(0);
            $table->enum('status', ['active', 'firstOpening', 'inactive', 'blocked'])->default('firstOpening');
            $table->double('balance')->default(0);
            $table->string('facebookLink')->nullable();
            $table->string('instagramLink')->nullable();
            $table->string('tiktokLink')->nullable();
            $table->string('whatsupLink')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magasins');
    }
};
