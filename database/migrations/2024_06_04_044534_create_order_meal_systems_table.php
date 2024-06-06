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
            CREATE OR REPLACE VIEW order_meal_systems as
            select
                om.order_id,
                min(om.meal_date) as from_date,
                max(om.meal_date) as to_date,
                count(distinct om.meal_date) as days,
                om.number_of_guest,
                om.order_meal_system_id,
                op.meal_system_for_meal_price_id,

                op.price
            from order_monitorings as om
            join order_wise_meal_prices as op
            on om.order_id = op.order_id and om.order_meal_system_id = op.meal_system_id
            group by meal_system_for_meal_price_id, om.number_of_guest , om.order_meal_system_id,om.order_id, op.price;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("DROP VIEW order_meal_systems");
    }
};
