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
        Schema::create('meal_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('service_type');
            $table->unsignedBigInteger('country_id')->comment('cuisine name');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(true);
            $table->foreign('country_id')->on('countries')->references('id')->cascadeOnDelete();
            $table->foreign('created_by')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('updated_by')->on('users')->references('id')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('meal_system_for_meal_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meal_system_id');
            $table->unsignedBigInteger('meal_price_id');
            $table->double('price', 10, 2);
            $table->foreign('meal_system_id')->on('meal_systems')->references('id')->cascadeOnDelete();
            $table->foreign('meal_price_id')->on('meal_prices')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_system_for_meal_price');
        Schema::dropIfExists('meal_prices');
    }
};
