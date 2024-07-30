<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EmptySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('countries')->truncate();
        DB::table('companies')->truncate();
        DB::table('meal_prices')->truncate();
        DB::table('meal_system_for_meal_price')->truncate();
        DB::table('hotels')->truncate();
        DB::table('halls')->truncate();
        DB::table('orders')->truncate();
        DB::table('meal_entries')->truncate();
        DB::table('order_monitorings')->truncate();
        DB::table('order_wise_meal_prices')->truncate();
        DB::table('invoices')->truncate();
        DB::table('invoice_data')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
