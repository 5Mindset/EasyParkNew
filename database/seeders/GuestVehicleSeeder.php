<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestVehicle;
use Illuminate\Support\Carbon;

class GuestVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GuestVehicle::create([
            'owner_name' => 'Budi Santoso',
            'plate_number' => 'N 1234 AB',
            'vehicle_type_id' => 1, 
            'entry_time' => Carbon::now()->subHours(2),
            'exit_time' => null,
            'status' => 'parked',
        ]);

        GuestVehicle::create([
            'owner_name' => 'Siti Aminah',
            'plate_number' => 'N 5678 CD',
            'vehicle_type_id' => 2,
            'entry_time' => Carbon::now()->subHours(3),
            'exit_time' => Carbon::now()->subHour(),
            'status' => 'parked',
        ]);
    }
}
