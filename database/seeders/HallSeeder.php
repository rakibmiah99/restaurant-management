<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Hall::factory()->count(100)->make();
        foreach ($data->toArray() as $item){
            try {
                Hall::create($item);
            }
            catch (\Exception $exception){
//                dd($exception->getMessage());
                continue;
            }
        }
    }
}
