<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\HallMealTime;
use App\Models\MealSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HallMealTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $halls = Hall::all();
        $meal_systems = MealSystem::pluck('id');
        $halls->each(function ($hall) use ($meal_systems){
            foreach ($meal_systems as $meal_system_id){
                HallMealTime::create([
                    'hall_id' => $hall->id,
                    'meal_system_id' => $meal_system_id,
                    'start_time' => fake()->time(),
                    'end_time' => fake()->time()
                ]);
            }
        });
    }
}
