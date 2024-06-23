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
        Schema::create('meal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('guest_name');
            $table->string('guest_info');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_meal_system_id');
            $table->unsignedBigInteger('meal_system_id');
            $table->date('taken_date');
            $table->time('taken_time');
            $table->unique(['guest_info','order_id', 'order_meal_system_id', 'meal_system_id', 'taken_date'], 'meal_entries_goomt_unique');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('order_meal_system_id')->references('id')->on('meal_systems')->cascadeOnDelete();
            $table->foreign('meal_system_id')->references('id')->on('meal_systems')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_entries');
    }
};
