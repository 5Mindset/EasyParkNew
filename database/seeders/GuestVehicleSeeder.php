<?php

namespace Database\Seeders;

use App\Models\GuestVehicle;
use App\Models\VehicleType;
use App\Models\ParkingArea;  // jangan lupa import ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GuestVehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleType = VehicleType::inRandomOrder()->first();
        $parkingArea = ParkingArea::inRandomOrder()->first();  // Ambil parking area acak

        if (!$vehicleType || !$parkingArea) {
            $this->command->warn('Belum ada data vehicle_types atau parking_areas. Seeder GuestVehicle tidak dijalankan.');
            return;
        }

        GuestVehicle::create([
            'name' => fake()->name(),
            'plate_number' => strtoupper(fake()->bothify('N #### ??')),
            'vehicle_type_id' => $vehicleType->id,
            'parking_area_id' => $parkingArea->id, // Tambahan ini
            'entry_time' => Carbon::now()->subHours(rand(1, 6)),
            'exit_time' => null,
            'status' => 'parked',
        ]);
    }
}
