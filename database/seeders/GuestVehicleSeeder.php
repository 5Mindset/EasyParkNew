<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestVehicle;
use App\Models\VehicleType;

class GuestVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan sudah ada data VehicleType
        if (VehicleType::count() === 0) {
            $this->command->warn('VehicleType belum ada. Jalankan seeder VehicleType dulu.');
            return;
        }

        // Contoh data manual untuk Guest Vehicle
        $guestVehicles = [
            ['plate_number' => 'N 1234 AB', 'owner_name' => 'John Doe', 'vehicle_type' => 'Motor'],
            ['plate_number' => 'N 5678 CD', 'owner_name' => 'Jane Smith', 'vehicle_type' => 'Mobil'],
            ['plate_number' => 'N 9101 EF', 'owner_name' => 'Alice Johnson', 'vehicle_type' => 'Motor'],
        ];

        foreach ($guestVehicles as $item) {
            // Cari tipe kendaraan berdasarkan nama
            $vehicleType = VehicleType::where('name', $item['vehicle_type'])->first();

            if ($vehicleType) {
                GuestVehicle::create([
                    'plate_number' => $item['plate_number'],
                    'owner_name' => $item['owner_name'],
                    'vehicle_type_id' => $vehicleType->id,
                    'entry_time' => now(),
                    'exit_time' => now()->addHours(1),
                    'status' => 'exited',
                ]);
            }
        }
    }
}
