<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\VehicleModel;
use Illuminate\Support\Str;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan sudah ada user dan model
        if (User::count() === 0 || VehicleModel::count() === 0) {
            $this->command->warn('User atau VehicleModel belum ada. Jalankan seeder-nya dulu.');
            return;
        }

        // Contoh data kendaraan hanya untuk mahasiswa
        $vehicles = [
            ['plate' => 'N 1234 AB', 'user_email' => 'mahasiswa@example.com', 'model' => 'Vario 150'],
            ['plate' => 'N 1111 ZZ', 'user_email' => 'mahasiswa2@example.com', 'model' => 'Beat Street'],
        ];

        foreach ($vehicles as $item) {
            // Ambil user dengan email dan pastikan role-nya adalah mahasiswa
            $user = User::where('email', $item['user_email'])
                        ->where('role', 'mahasiswa') // ganti sesuai struktur role kamu
                        ->first();

            $model = VehicleModel::where('name', $item['model'])->first();

            if ($user && $model) {
                Vehicle::firstOrCreate([
                    'plate_number' => $item['plate'],
                    'user_id' => $user->id,
                    'vehicle_model_id' => $model->id,
                    'stnk_image' => 'uploads/stnk/default.png',
                    'qr_code' => Str::uuid(),
                ]);
            }
        }
    }
}
