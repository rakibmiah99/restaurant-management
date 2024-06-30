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
                om.order_id,
                om.meal_date,
                om.meal_system_id,
                sum(om.number_of_guest) as total_guest,
                h.b_start,
                h.b_end,
                h.l_start,
                h.l_end,
                h.d_start,
                h.d_end,
                h.s_start,
                h.s_end,
                h.i_start,
                h.i_end
            from order_monitorings as om
                     inner join orders as o
                                on o.id = om.order_id
                     inner join halls as h
                                on o.hall_id = h.id
            group by
                om.order_id,
                om.meal_date,
                om.meal_system_id,
                h.b_start,
                h.b_end,
                h.l_start,
                h.l_end,
                h.d_start,
                h.d_end,
                h.s_start,
                h.s_end,
                h.i_start,
                h.i_end
            order by om.meal_date ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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
};
