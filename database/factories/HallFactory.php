<?php

namespace Database\Factories;

use App\Models\Hall;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hall>
 */
class HallFactory extends Factory
{
    protected $model = Hall::class;
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
            'capacity' => fake()->numberBetween(10, 200),
            'status' => fake()->randomElement([true, false]),
            'hotel_id' => fake()->randomElement(Hotel::pluck('id')),
            'created_by' => fake()->randomElement(User::pluck('id')),
        ];
    }
}
