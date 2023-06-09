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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product');
            // $table->unsignedBigInteger('id_note_cart')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_outlet');
            $table->foreign('id_product')->references('id')->on('products');
            // $table->foreign('id_note_cart')->references('id')->on('note_cart');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_outlet')->references('id')->on('outlets');
            $table->text('note')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('type_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
