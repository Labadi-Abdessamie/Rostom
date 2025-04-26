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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('supplierName');
            $table->double('totalAmount');
            $table->date('doneDate');
            $table->enum('type', ['quote', 'order', 'delivery']);
            $table->enum('paymentStatus', ['full', 'partial', 'debt']);
            $table->unsignedBigInteger('magasin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
