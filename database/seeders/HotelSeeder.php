<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Hotel::factory()->count(100)->make();

        foreach ($data->toArray() as $hotel){
            try{
                Hotel::create($hotel);
            }
            catch (\Exception $exception){
                continue;
            }
        }

    }
}
