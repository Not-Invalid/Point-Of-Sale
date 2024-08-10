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
        Schema::create('stock_management', function (Blueprint $table) {
            $table->id();
            $table->date('input_date');
            $table->string('product_id');
            $table->string('id_brand');
            $table->string('id_category');
            $table->integer('quantity');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('id_brand')->references('brand_id')->on('brand')->onDelete('cascade');
            $table->foreign('id_category')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_management', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['id_brand']);
            $table->dropForeign(['id_category']);
        });

        Schema::dropIfExists('stock_management');
    }
};
