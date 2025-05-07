<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;

class VehicleBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Honda'
        ];

        foreach ($brands as $brand) {
            VehicleBrand::firstOrCreate(['name' => $brand]);
        }
    }
}
