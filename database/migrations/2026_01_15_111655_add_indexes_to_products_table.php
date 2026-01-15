<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('category_id');
            $table->index('brand_id');

            $table->index(['is_active', 'category_id', 'price']);

            $table->index('volume');
            $table->index('finish_type');

            $table->index('created_at');
            $table->index('total_sold');
            $table->index('rating_avg');

            $table->index(['is_featured', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['brand_id']);

            $table->dropIndex(['is_active', 'category_id', 'price']);

            $table->dropIndex(['volume']);
            $table->dropIndex(['finish_type']);

            $table->dropIndex(['created_at']);
            $table->dropIndex(['total_sold']);
            $table->dropIndex(['rating_avg']);

            $table->dropIndex(['is_featured', 'is_active']);
        });
    }
};
