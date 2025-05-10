<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            VehicleTypeSeeder::class,
            VehicleBrandSeeder::class,
            VehicleModelSeeder::class,
            VehicleSeeder::class,
            // ParkingRecordSeeder::class,
            // GuestVehicleSeeder::class,
            // Seeder lain jika ada 
        ]);
    }
}
