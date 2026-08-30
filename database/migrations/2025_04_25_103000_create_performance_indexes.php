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
        // Indexes for magasins table
        Schema::table('magasins', function (Blueprint $table) {
            $table->index('status');
            $table->index('location');
            $table->index('category_id');
            $table->index('user_id');
            $table->index('rate');
        });

        // Indexes for products table
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('magasin_id');
            $table->index('actual_quantity');
            $table->index('rate_count');
        });

        // Indexes for orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('doneDate');
            $table->index('shippingAddress_id');
            $table->index('billingAddress_id');
        });

        // Indexes for variants table
        Schema::table('variants', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('quantity');
        });

        // Indexes for bag_items table
        Schema::table('bag_items', function (Blueprint $table) {
            $table->index('bag_id');
            $table->index('product_id');
        });

        // Indexes for order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
        });

        // Indexes for categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('parentId');
            $table->index('status');
        });

        // Indexes for reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('product_id');
            $table->index('rate');
        });

        // Indexes for product_images table
        Schema::table('product_images', function (Blueprint $table) {
            $table->index('product_id');
        });

        // Indexes for addresses table
        Schema::table('addresses', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('type');
            $table->index('principalAddress');
        });

        // Indexes for bags table
        Schema::table('bags', function (Blueprint $table) {
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from magasins table
        Schema::table('magasins', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['location']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['rate']);
        });

        // Remove indexes from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['magasin_id']);
            $table->dropIndex(['actual_quantity']);
            $table->dropIndex(['rate_count']);
        });

        // Remove indexes from orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['doneDate']);
            $table->dropIndex(['shippingAddress_id']);
            $table->dropIndex(['billingAddress_id']);
        });

        // Remove indexes from variants table
        Schema::table('variants', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['quantity']);
        });

        // Remove indexes from bag_items table
        Schema::table('bag_items', function (Blueprint $table) {
            $table->dropIndex(['bag_id']);
            $table->dropIndex(['product_id']);
        });

        // Remove indexes from order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
        });

        // Remove indexes from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['parentId']);
            $table->dropIndex(['status']);
        });

        // Remove indexes from reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['rate']);
        });

        // Remove indexes from product_images table
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
        });

        // Remove indexes from addresses table
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['principalAddress']);
        });

        // Remove indexes from bags table
        Schema::table('bags', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });
    }
};