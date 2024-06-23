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
        \Illuminate\Support\Facades\DB::statement("
            Create Or Replace view date_wise_monitors as
            select
                order_id,
                meal_date,
                meal_system_id,
                sum(number_of_guest) as total_guest
            from order_monitorings
            group by order_id, meal_date, meal_system_id
            order by meal_date ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement('DROP VIEW date_wise_monitors');
    }
};
