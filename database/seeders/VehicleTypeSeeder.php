<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleTypes = [
            [
                'id' => 1,
                'name' => 'Motor',
                'area_size' => 1.3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Mobil',
                'area_size' => 7.5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($vehicleTypes as $type) {
            VehicleType::updateOrCreate(
                ['id' => $type['id']],
                $type
            );
        }
    }
}
