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
        Schema::create('order_monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('meal_system_type', \App\MealSystemType::toArray());
            $table->double('number_of_guest', 10,2);
            $table->date('meal_date');
            $table->unsignedBigInteger('order_meal_system_id');
            $table->unsignedBigInteger('meal_system_id')->comment('for base meal system');
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete();
            $table->foreign('order_meal_system_id')->on('meal_systems')->references('id')->cascadeOnDelete();
            $table->foreign('meal_system_id')->on('meal_systems')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_monitorings');
    }
};
