<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealSystem extends Model
{
    use HasFactory;


    public function getAllowMealSystemAttribute(){
        $mealSystemIdsMap = [
            1 => [5, 6, 7],
            2 => [5, 6],
            3 => [6, 7],
            4 => [6, 7],
            5 => [6],
            6 => [6],
            7 => [7],
            8 => [9, 10],
            9 => [9],
            10 => [10],
        ];

        // Check if the current ID exists in the mapping array
        if (!isset($mealSystemIdsMap[$this->id])) {
            return [];
        }

        $mealSystemIds = $mealSystemIdsMap[$this->id];
        $mealSystems = MealSystem::find($mealSystemIds);

        // Create the meals array
        $meals = [];
        foreach ($mealSystems as $mealSystem) {
            $meals[] = (object)[
                'id' => $mealSystem->id,
                'name' => $mealSystem->name,
            ];
        }

        return $meals;
    }
}
