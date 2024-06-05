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
        Schema::create('order_wise_meal_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('meal_system_id');
            $table->unsignedBigInteger('meal_system_for_meal_price_id');
            $table->double('price', 10,2);
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete();
            $table->foreign('meal_system_id')->on('meal_systems')->references('id')->cascadeOnDelete();
            $table->foreign('meal_system_for_meal_price_id')->on('meal_system_for_meal_price')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_wise_meal_prices');
    }
};
