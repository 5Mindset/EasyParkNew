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
            ['name' => 'Honda Vario 125', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Scoopy', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Beat', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda PCX160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Beat Street', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda CRF150L', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Stylo 160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Vario 160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda ADV 160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Supra GTR 150', 'brand' => 'Honda', 'type' => 'Motor'],

            ['name' => 'Honda Vario 125', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Scoopy', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Beat', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda PCX160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Beat Street', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda CRF150L', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Stylo 160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Vario 160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda ADV 160', 'brand' => 'Honda', 'type' => 'Motor'],
            ['name' => 'Honda Supra GTR 150', 'brand' => 'Honda', 'type' => 'Motor'],
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
