<?php

namespace Database\Seeders;

use App\Http\Controllers\CopyController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(EmptySeeder::class);
        $copy = new CopyController();
        $copy->country();
        $copy->hotel();
        $copy->hall();
        $copy->meal_price();
        $copy->company();
        $copy->orders();
        
        if(isset($this->command)) {
            $this->command->info("Data has been copied successfully. \n");
        }
    }
}
