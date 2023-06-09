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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order')->nullable();
            $table->unsignedBigInteger('id_product')->nullable();
            $table->foreign('id_order')->references('id')->on('orders');
            $table->foreign('id_product')->references('id')->on('products');
            // $table->string('product');
            $table->double('quantity');
            // $table->string('type_order');
            $table->string('note')->nullable();
            $table->double('price')->nullable();
            // $table->double('discount');
            // $table->double('add_on_price')->nullable();
            // $table->double('varian_price')->nullable();
            // $table->double('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
