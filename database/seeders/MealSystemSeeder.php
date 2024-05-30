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
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'HB -> Breakfast/Launch',
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'HB-> Breakfast/Dinner',
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Lunch/Dinner',
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Breakfast',
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Lunch',
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Dinner',
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'name' => 'Full Board',
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'name' => 'Sheri',
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'name' => 'Iftar',
                'type' => MealSystemType::RAMADAN->value
            ],
        ];


        DB::table('meal_systems')->truncate();
        foreach ($mealSystem as $item){
            MealSystem::create($item);
        }
    }
}
