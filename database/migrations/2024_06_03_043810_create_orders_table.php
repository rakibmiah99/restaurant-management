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
            $table->string('order_number')->unique();
            $table->date('order_date');
            $table->enum('service_type', \App\ServiceType::toArray());
            $table->boolean('status')->default(true);
            $table->text('order_note');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('hall_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('mpi_for_normal')->comment('mpi=meal price id')->nullable();
            $table->unsignedBigInteger('mpi_for_ramadan')->comment('mpi=meal price id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')->on('companies')->references('id')->cascadeOnDelete();
            $table->foreign('hotel_id')->on('hotels')->references('id')->cascadeOnDelete();
            $table->foreign('hall_id')->on('halls')->references('id')->cascadeOnDelete();
            $table->foreign('mpi_for_normal')->on('meal_prices')->references('id')->cascadeOnDelete();
            $table->foreign('mpi_for_ramadan')->on('meal_prices')->references('id')->cascadeOnDelete();
            $table->foreign('created_by')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('updated_by')->on('users')->references('id')->cascadeOnDelete();
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
