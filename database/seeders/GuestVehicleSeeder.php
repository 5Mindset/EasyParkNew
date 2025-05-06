<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestVehicle;
use App\Models\VehicleModel; // Pastikan VehicleModel sudah ada
use Illuminate\Support\Str;

class GuestVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Pastikan sudah ada data VehicleModel
        if (VehicleModel::count() === 0) {
            $this->command->warn('VehicleModel belum ada. Jalankan seeder VehicleModel dulu.');
            return;
        }

        // Contoh data manual untuk Guest Vehicle
        $guestVehicles = [
            ['plate_number' => 'N 1234 AB', 'owner_name' => 'John Doe', 'vehicle_model' => 'Vario 150'],
            ['plate_number' => 'N 5678 CD', 'owner_name' => 'Jane Smith', 'vehicle_model' => 'Fortuner'],
            ['plate_number' => 'N 9101 EF', 'owner_name' => 'Alice Johnson', 'vehicle_model' => 'Xenia'],
            // Tambahkan data lainnya jika diperlukan
        ];

        foreach ($guestVehicles as $item) {
            // Cari model kendaraan berdasarkan nama
            $vehicleModel = VehicleModel::where('name', $item['vehicle_model'])->first();

            if ($vehicleModel) {
                GuestVehicle::create([
                    'plate_number' => $item['plate_number'],
                    'owner_name' => $item['owner_name'],
                    'vehicle_model_id' => $vehicleModel->id,
                    'entry_time' => now(), // waktu saat ini sebagai entry time
                    'exit_time' => now()->addHours(1), // waktu 1 jam setelah entry sebagai exit time
                    'status' => 'parked', // status awal kendaraan
                ]);
            }
        }
    }
}
