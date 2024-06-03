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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('capacity');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('hotel_id');
            $table->time('b_start')->comment('breakfast start time');
            $table->time('b_end')->comment('breakfast end time');
            $table->time('l_start')->comment('Lunch start time');
            $table->time('l_end')->comment('Lunch end time');
            $table->time('d_start')->comment('Dinner start time');
            $table->time('d_end')->comment('Dinner end time');
            $table->time('s_start')->comment('Seheri start time');
            $table->time('s_end')->comment('Seheri end time');
            $table->time('i_start')->comment('Iftar start time');
            $table->time('i_end')->comment('Iftar end time');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('hotel_id')->on('hotels')->references('id')->cascadeOnDelete();
            $table->foreign('created_by')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('updated_by')->on('users')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
