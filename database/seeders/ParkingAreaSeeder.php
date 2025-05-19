<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingArea;

class ParkingAreaSeeder extends Seeder
{
    public function run(): void
    {
        ParkingArea::create(['name' => 'Polije Kampus 2 Bondowoso', 'max_area' => 896.00]);
    }
}
