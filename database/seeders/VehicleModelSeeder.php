<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        if (VehicleBrand::count() === 0) {
            $this->command->warn('VehicleBrand belum ada. Jalankan seeder-nya dulu.');
            return;
        }

        $models = [
            ['name' => 'Honda Vario 125', 'brand' => 'Honda'],
            ['name' => 'Honda Scoopy', 'brand' => 'Honda'],
            ['name' => 'Royal Enfield Himalayan 450', 'brand' => 'Royal Enfield'],
        ];

        foreach ($models as $model) {
            $brand = VehicleBrand::where('name', $model['brand'])->first();

            if ($brand) {
                VehicleModel::firstOrCreate([
                    'name' => $model['name'],
                    'vehicle_brand_id' => $brand->id,
                ]);
            }
        }
    }
}
