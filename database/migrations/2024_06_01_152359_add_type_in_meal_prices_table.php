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
        Schema::table('meal_prices', function (Blueprint $table) {
             $table->enum('type', \App\MealSystemType::toArray())->after('country_id')->default(\App\MealSystemType::NORMAL->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meal_prices', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
