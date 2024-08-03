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
                om.order_meal_system_id,
                sum(om.number_of_guest) as total_guest,
                CASE om.meal_system_id
                    WHEN 5 THEN CONCAT(om.meal_date,' ', h.b_start)
                    WHEN 6 THEN CONCAT(om.meal_date,' ', h.l_start)
                    WHEN 7 THEN CONCAT(om.meal_date,' ', h.d_start)
                    WHEN 9 THEN CONCAT(om.meal_date,' ', h.s_start)
                    WHEN 10 THEN CONCAT(om.meal_date,' ', h.i_start)
                    END AS start_time,

                CASE om.meal_system_id
                    WHEN 5 THEN CONCAT(om.meal_date,' ', h.b_end)
                    WHEN 6 THEN CONCAT(om.meal_date,' ', h.l_end)
                    WHEN 7 THEN CONCAT(om.meal_date,' ', h.d_end)
                    WHEN 9 THEN CONCAT(om.meal_date,' ', h.s_end)
                    WHEN 10 THEN CONCAT(om.meal_date,' ', h.i_end)
                    END AS end_time,

                CASE om.meal_system_id
                    WHEN 5 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.b_start) AND CONCAT(om.meal_date, ' ', h.b_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.b_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.b_start)
                                THEN  1
                            END
                    WHEN 6 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.l_start) AND CONCAT(om.meal_date, ' ', h.l_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.l_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.l_start)
                                THEN  1
                            END
                    WHEN 7 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.d_start) AND CONCAT(om.meal_date, ' ', h.d_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.d_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.d_start)
                                THEN  1
                            END
                    WHEN 9 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.s_start) AND CONCAT(om.meal_date, ' ', h.s_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.s_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.s_start)
                                THEN  1
                            END
                    WHEN 10 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.i_start) AND CONCAT(om.meal_date, ' ', h.i_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.i_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.i_start)
                                THEN  1
                            END
                    END AS execution_status

            from order_monitorings as om
                     join orders as o
                          on om.order_id = o.id

                     join halls as h
                          on o.hall_id = h.id

            group by
                om.order_id,
                om.meal_date,
                om.meal_system_id,
                om.order_meal_system_id,
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
                om.order_id,
                om.meal_date,
                om.meal_system_id,
                sum(om.number_of_guest) as total_guest,
                CASE om.meal_system_id
                    WHEN 5 THEN CONCAT(om.meal_date,' ', h.b_start)
                    WHEN 6 THEN CONCAT(om.meal_date,' ', h.l_start)
                    WHEN 7 THEN CONCAT(om.meal_date,' ', h.d_start)
                    WHEN 9 THEN CONCAT(om.meal_date,' ', h.s_start)
                    WHEN 10 THEN CONCAT(om.meal_date,' ', h.i_start)
                    END AS start_time,

                CASE om.meal_system_id
                    WHEN 5 THEN CONCAT(om.meal_date,' ', h.b_end)
                    WHEN 6 THEN CONCAT(om.meal_date,' ', h.l_end)
                    WHEN 7 THEN CONCAT(om.meal_date,' ', h.d_end)
                    WHEN 9 THEN CONCAT(om.meal_date,' ', h.s_end)
                    WHEN 10 THEN CONCAT(om.meal_date,' ', h.i_end)
                    END AS end_time,

                CASE om.meal_system_id
                    WHEN 5 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.b_start) AND CONCAT(om.meal_date, ' ', h.b_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.b_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.b_start)
                                THEN  1
                            END
                    WHEN 6 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.l_start) AND CONCAT(om.meal_date, ' ', h.l_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.l_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.l_start)
                                THEN  1
                            END
                    WHEN 7 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.d_start) AND CONCAT(om.meal_date, ' ', h.d_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.d_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.d_start)
                                THEN  1
                            END
                    WHEN 9 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.s_start) AND CONCAT(om.meal_date, ' ', h.s_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.s_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.s_start)
                                THEN  1
                            END
                    WHEN 10 THEN
                        CASE
                            WHEN now() BETWEEN CONCAT(om.meal_date, ' ', h.i_start) AND CONCAT(om.meal_date, ' ', h.i_end)
                                THEN 0
                            WHEN now() > CONCAT(om.meal_date, ' ', h.i_start)
                                THEN -1
                            WHEN now() < CONCAT(om.meal_date, ' ', h.i_start)
                                THEN  1
                            END
                    END AS execution_status

            from order_monitorings as om
                     join orders as o
                          on om.order_id = o.id

                     join halls as h
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
};
