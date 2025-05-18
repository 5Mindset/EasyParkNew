<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestVehicle;

class GuestVehicleSeeder extends Seeder
{
    public function run(): void
    {
        GuestVehicle::factory()->count(20)->create();
    }
}

