<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;

class VehicleBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Honda', 'Yamaha', 'Kawasaki', 'Suzuki', 'Benelli', 'KTM', 'TVS', 'BMW',
            'Viar', 'Vespa', 'Royal Enfield'
        ];

        foreach ($brands as $brand) {
            VehicleBrand::firstOrCreate(['name' => $brand]);
        }
    }
}
