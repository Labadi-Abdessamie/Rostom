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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'processing', 'confirmed', 'delivered', 'cancelled'])->default('pending');
            $table->string('details')->nullable();
            $table->double('totalAmount');
            $table->date('date');
            $table->enum('paymentMethod', ['cashOnDelivery', 'Edahabia']);
            $table->enum('paymentStatus', ['inProgress', 'failed', 'success']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shippingAddress_id');
            $table->unsignedBigInteger('billingAddress_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
