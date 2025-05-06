<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan sudah ada data brand dan type
        if (VehicleBrand::count() === 0 || VehicleType::count() === 0) {
            $this->command->warn('VehicleBrand or VehicleType belum ada. Jalankan seeder-nya dulu.');
            return;
        }

        // Contoh data manual
        $models = [
            ['name' => 'Vario 150', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Beat Street', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Fortuner', 'brand' => 'Toyota', 'type' => 'Mobil'],
            ['name' => 'Xenia', 'brand' => 'Daihatsu', 'type' => 'Mobil'],
        ];

        foreach ($models as $model) {
            $brand = VehicleBrand::where('name', $model['brand'])->first();
            $type = VehicleType::where('name', $model['type'])->first();

            if ($brand && $type) {
                VehicleModel::firstOrCreate([
                    'name' => $model['name'],
                    'vehicle_brand_id' => $brand->id,
                    'vehicle_type_id' => $type->id,
                ]);
            }
        }
    }
}
