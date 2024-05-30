<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MealPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Company::factory()->count(100)->make()->toArray();
        Company::factory()->createMany($data);

    }
}
