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
        Schema::create('hall_meal_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id');
            $table->unsignedBigInteger('meal_system_id')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->foreign('hall_id')->on('halls')->references('id')->cascadeOnDelete();
            $table->foreign('meal_system_id')->on('meal_systems')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_meal_times');
    }
};
