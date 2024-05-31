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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('tax')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('agent_mobile')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('meal_price_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('country_id')->on('countries')->references('id')->cascadeOnDelete();
            $table->foreign('created_by')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('updated_by')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('meal_price_id')->on('meal_prices')->references('id')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
