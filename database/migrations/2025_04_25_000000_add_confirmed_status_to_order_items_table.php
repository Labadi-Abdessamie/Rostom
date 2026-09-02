<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `order_items` CHANGE `status` `status` ENUM('pending', 'notAvailable', 'available', 'confirmed') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `order_items` CHANGE `status` `status` ENUM('pending', 'notAvailable', 'available') DEFAULT 'pending'");
    }
};
