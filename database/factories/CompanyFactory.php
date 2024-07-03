<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Country;
use App\Models\MealPrice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;
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
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'website' => fake()->url(),
            'tax' => fake()->numberBetween(10, 50),
            'agent_name' => fake()->name(),
            'agent_mobile' => fake()->phoneNumber(),
            'country_id' => fake()->randomElement(Country::pluck('id')),
            'meal_price_id' => fake()->randomElement(MealPrice::pluck('id')),
            'created_by' => fake()->randomElement(User::pluck('id')),
            'status' => fake()->randomElement([true, false])
        ];
    }
}
