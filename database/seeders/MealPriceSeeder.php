<?php

namespace Database\Seeders;

use App\Models\MealPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $meal_prices = MealPrice::factory()->count(100)->make()->toArray();
        MealPrice::factory()->createMany($meal_prices);

    }
}
