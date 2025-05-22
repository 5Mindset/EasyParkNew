<?php

namespace Database\Seeders;

use App\Models\GuestVehicle;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GuestVehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleType = VehicleType::inRandomOrder()->first();

        if (!$vehicleType) {
            $this->command->warn('Belum ada data vehicle_types. Seeder GuestVehicle tidak dijalankan.');
            return;
        }

        GuestVehicle::create([
            'name' => fake()->name(),
            'plate_number' => strtoupper(fake()->bothify('N #### ??')),
            'vehicle_type_id' => $vehicleType->id,
            'entry_time' => Carbon::now()->subHours(rand(1, 6)),
            'exit_time' => null,
            'status' => 'parked',
        ]);
    }
}
