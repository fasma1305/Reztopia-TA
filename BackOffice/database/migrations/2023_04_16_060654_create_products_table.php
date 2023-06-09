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
            $table->id();
            $table->unsignedBigInteger('id_category')->nullable();
            $table->foreign('id_category')->references('id')->on('categories');
            $table->string('name');
            $table->string('sku')->nullable();
            // $table->string('slug');
            $table->text('description');
            $table->double('original_price')->default(0);
            $table->double('cost_price')->default(0);
            $table->double('discount')->default(0)->nullable();
            $table->double('price_final')->default(0)->nullable();
            // $table->double('cost')->default(0);
            $table->string('active');
            $table->string('image')->nullable();
            $table->string('type_product');
            $table->bigInteger('created_by');
            $table->timestamps();
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
