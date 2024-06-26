<?php

namespace Database\Seeders;

use App\MealSystemType;
use App\Models\MealSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mealSystem = [
            [
                'name' => 'Full Board',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'HB -> Breakfast/Launch',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'HB-> Breakfast/Dinner',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Lunch/Dinner',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Breakfast',
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Lunch',
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Dinner',
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Full Board',
                'is_main' => false,
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'name' => 'Sheri',
                'is_main' => true,
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'name' => 'Iftar',
                'is_main' => true,
                'type' => MealSystemType::RAMADAN->value
            ],
        ];


        DB::table('meal_systems')->truncate();
        foreach ($mealSystem as $item){
            MealSystem::create($item);
        }
    }
}
