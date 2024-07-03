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
                'id' => 1,
                'name' => 'Full Board',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 2,
                'name' => 'HB -> Breakfast/Launch',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 3,
                'name' => 'HB-> Breakfast/Dinner',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 4,
                'name' => 'Lunch/Dinner',
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 5,
                'name' => 'Breakfast',
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 6,
                'name' => 'Lunch',
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 7,
                'name' => 'Dinner',
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 8,
                'name' => 'Full Board',
                'is_main' => false,
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'id' => 9,
                'name' => 'Sheri',
                'is_main' => true,
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'id' => 10,
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
