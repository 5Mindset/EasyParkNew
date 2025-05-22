<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleTypes = [
            ['id' => 1, 'name' => 'Motor', 'area_size' => 1.3],
            ['id' => 2, 'name' => 'Mobil', 'area_size' => 7.5],
        ];

        foreach ($vehicleTypes as $type) {
            VehicleType::updateOrCreate(
                ['id' => $type['id']],
                [
                    'name' => $type['name'],
                    'area_size' => $type['area_size'],
                ]
            );
        }
    }
}
