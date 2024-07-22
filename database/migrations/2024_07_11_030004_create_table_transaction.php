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
        Schema::create('transaction', function (Blueprint $table) {
            $table->string('transaction_number', 255)->primary();
            $table->string('product_name', 255); 
            $table->unsignedBigInteger('id_brand')->index();
            $table->unsignedBigInteger('id_category')->index();
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();

            
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
