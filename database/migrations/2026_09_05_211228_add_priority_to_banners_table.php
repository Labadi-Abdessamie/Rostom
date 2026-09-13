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
        Schema::table('banners', function (Blueprint $table) {
            // "priority" controls the order within the same page+position slot.
            // 1 = first, 2 = second, etc. So position 1 priority 1 is the very
            // first banner section on the home page.
            $table->unsignedInteger('priority')->default(1)->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};
