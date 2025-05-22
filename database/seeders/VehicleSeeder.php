<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::inRandomOrder()->first();
        $vehicleModel = VehicleModel::with('vehicleBrand.vehicleType')->inRandomOrder()->first();

        if (!$user || !$vehicleModel) {
            $this->command->warn('User atau VehicleModel belum ada, seeder Vehicle tidak dijalankan.');
            return;
        }

        Vehicle::create([
            'plate_number' => strtoupper(fake()->bothify('N #### ??')),
            'vehicle_model_id' => $vehicleModel->id,
            'user_id' => $user->id,
            'stnk_image' => 'uploads/stnk/dummy-stnk.png',
            'qr_code' => Str::uuid(), 
        ]);
    }
}
