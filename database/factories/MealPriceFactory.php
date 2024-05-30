<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\MealPrice;
use App\Models\User;
use App\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealPrice>
 */
class MealPriceFactory extends Factory
{
    protected $model = MealPrice::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'code' => fake()->numberBetween(1000, 9999),
            'service_type' => fake()->randomElement(ServiceType::toArray()),
            'country_id' => fake()->randomElement(Country::pluck('id')),
            'created_by' => fake()->randomElement(User::pluck('id')),
            'status' => fake()->randomElement([true, false])
        ];
    }
}
