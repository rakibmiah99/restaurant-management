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
            Create Or Replace view date_and_meal_s_wise_monitors as
            select
                om.order_id,
                om.number_of_guest,
                om.meal_system_type,
                om.meal_date,
                om.order_meal_system_id,
                op.meal_system_for_meal_price_id,
                op.price
            from order_monitorings as om
            join order_wise_meal_prices as op
              on om.order_id = op.order_id and om.order_meal_system_id = op.meal_system_id
            group by
                op.meal_system_for_meal_price_id,
                om.number_of_guest,
                om.meal_system_type,
                om.order_id,
                om.order_meal_system_id,
                om.meal_date,
                op.price
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("DROP VIEW date_and_meal_s_wise_monitors");
    }
};
