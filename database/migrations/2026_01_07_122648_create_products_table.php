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
            $table->id('product_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('paint_base');
            $table->string('finish_type');
            $table->integer('volume');
            $table->integer('coverage_area');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity');
            $table->integer('low_stock_alert');
            $table->string('image_url')->nullable();
            $table->float('rating_avg')->default(0);
            $table->integer('total_sold')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('brand_id')->references('brand_id')->on('brands');
            $table->foreign('category_id')->references('category_id')->on('categories');

            $table->index('is_active');
            $table->index('category_id');
            $table->index('brand_id');

            $table->index(['is_active', 'category_id', 'price']);

            $table->index('volume');
            $table->index('finish_type');

            $table->index('created_at');
            $table->index('total_sold');
            $table->index('coverage_area');
            $table->index('rating_avg');

            $table->index(['is_featured', 'is_active']);
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
