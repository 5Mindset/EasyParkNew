<?php

namespace Database\Seeders;

use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class ParkingRecordSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan sudah ada kendaraan
        if (Vehicle::count() === 0) {
            $this->command->warn('Vehicle belum ada. Jalankan seeder untuk kendaraan dulu.');
            return;
        }

        // Dapatkan ID kendaraan pertama yang sudah ada
        $vehicleIds = Vehicle::pluck('id')->toArray();

        // Pastikan ada kendaraan dengan ID 1
        if (empty($vehicleIds)) {
            $this->command->warn('Tidak ada kendaraan di database.');
            return;
        }

        // Data parkir contoh
        $parkingRecords = [
            ['vehicle_id' => $vehicleIds[0], 'entry_time' => now()->subHours(2), 'exit_time' => now()->subMinutes(30), 'status' => 'exited'],
            ['vehicle_id' => $vehicleIds[0], 'entry_time' => now()->subDay(), 'exit_time' => now(), 'status' => 'parked'],
        ];

        foreach ($parkingRecords as $record) {
            ParkingRecord::firstOrCreate($record);
        }
    }
}
