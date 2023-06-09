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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_outlet')->nullable();
            $table->unsignedBigInteger('id_order_status')->nullable();
            // $table->unsignedBigInteger('id_order_detail')->nullable();
            $table->unsignedBigInteger('id_category')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_outlet')->references('id')->on('outlets');
            $table->foreign('id_order_status')->references('id')->on('order_status');
            // $table->foreign('id_order_detail')->references('id')->on('order_details');
            $table->foreign('id_category')->references('id')->on('categories');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('cashier')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('order_type')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('table_number')->nullable();
            $table->double('total')->nullable();
            $table->double('paid')->nullable();
            $table->double('return')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->text('link')->nullable();
            $table->text('payment_url')->nullable();
            $table->date('deleted_at')->nullable();
            $table->date('date_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
