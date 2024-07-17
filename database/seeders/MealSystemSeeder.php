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
                'name' => [
                    'en' => 'Full Board',
                    'ar' => 'فل بورد'
                ],
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 2,
                'name' => [
                    'en' => 'HB -> Breakfast/Launch',
                    'ar' => 'هاف بورد -> إفطار / غداء'
                ],
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 3,
                'name' => [
                    'en' => 'HB-> Breakfast/Dinner',
                    'ar' => 'هاف بورد -> إفطار / عشاء'
                ],
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 4,
                'name' => [
                    'en' => 'HB-> Lunch/Dinner',
                    'ar' => 'هاف بورد -> غداء / عشاء'
                ],
                'is_main' => false,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 5,
                'name' => [
                    'en' => 'Breakfast',
                    'ar' => 'إفطار'
                ],
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 6,
                'name' => [
                    'en' => 'Lunch',
                    'ar' => 'غداء'
                ],
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 7,
                'name' => [
                    'en' => 'Dinner',
                    'ar' => 'عشاء'
                ],
                'is_main' => true,
                'type' => MealSystemType::NORMAL->value
            ],
            [
                'id' => 8,
                'name' => [
                    'en' => 'Full Board',
                    'ar' => 'فل بورد'
                ],
                'is_main' => false,
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'id' => 9,
                'name' => [
                    'en' => 'Suhoor',
                    'ar' => 'سحور'
                ],
                'is_main' => true,
                'type' => MealSystemType::RAMADAN->value
            ],
            [
                'id' => 10,
                'name' => [
                    'en' => 'Iftar',
                    'ar' => 'إفطار'
                ],
                'is_main' => true,
                'type' => MealSystemType::RAMADAN->value
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('meal_systems')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        foreach ($mealSystem as $item){
//            $item['name'] = json_encode($item['name']);
            MealSystem::create($item);
        }
    }
}
