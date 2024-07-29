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
            $table->string('product_id', 255)->primary();
            $table->string('product_name')->nullable();
            $table->string('desc_product');
            $table->integer('stock');
            $table->decimal('unit_price', 10, 2);
            $table->string('id_brand')->index();
            $table->string('id_category')->index();
            $table->string('product_image')->nullable();
            $table->timestamps();

            $table->foreign('id_brand')->references('brand_id')->on('brand')->onDelete('cascade');
            $table->foreign('id_category')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['id_brand']);
            $table->dropForeign(['id_category']);
        });

        Schema::dropIfExists('products');
    }
};
