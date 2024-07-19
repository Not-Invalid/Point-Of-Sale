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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('desc_product');
            $table->integer('stock');
            $table->decimal('unit_price', 10, 2);
            $table->unsignedBigInteger('id_brand')->index();
            $table->unsignedBigInteger('id_category')->index();
            $table->string('product_image');
            $table->timestamps();

            $table->foreign('id_brand')->references('id')->on('brand')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign(['id_brand']);
            $table->dropForeign(['id_category']);
        });

        Schema::dropIfExists('product');
    }
};
