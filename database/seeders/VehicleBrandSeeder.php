<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;

class VehicleBrandSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh, setiap brand diberi relasi ke vehicle_type_id yang sesuai
        // Misal: motor = 1, mobil = 2 (sesuaikan dengan data di tabel vehicle_types-mu)
        $brands = [
            ['name' => 'Honda', 'vehicle_type_id' => 1],       // Motor
            ['name' => 'Yamaha', 'vehicle_type_id' => 1],      // Motor
            ['name' => 'Kawasaki', 'vehicle_type_id' => 1],    // Motor
            ['name' => 'Suzuki', 'vehicle_type_id' => 1],      // Motor
            ['name' => 'Benelli', 'vehicle_type_id' => 1],     // Motor
            ['name' => 'KTM', 'vehicle_type_id' => 1],         // Motor
            ['name' => 'TVS', 'vehicle_type_id' => 1],         // Motor
            ['name' => 'BMW', 'vehicle_type_id' => 2],         // Mobil (misal BMW mobil)
            ['name' => 'Viar', 'vehicle_type_id' => 1],        // Motor
            ['name' => 'Vespa', 'vehicle_type_id' => 1],       // Motor
            ['name' => 'Royal Enfield', 'vehicle_type_id' => 1]// Motor
        ];

        foreach ($brands as $brand) {
            VehicleBrand::firstOrCreate(
                ['name' => $brand['name']],
                ['vehicle_type_id' => $brand['vehicle_type_id']]
            );
        }
    }
}
