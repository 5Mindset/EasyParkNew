<?php

namespace Database\Factories;

use App\Models\GuestVehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GuestVehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GuestVehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil model kendaraan secara acak
        $vehicleModel = VehicleModel::inRandomOrder()->first();

        return [
            'plate_number' => strtoupper('N ' . fake()->unique()->numberBetween(1000, 9999) . ' ' . Str::upper(fake()->randomLetter()) . Str::upper(fake()->randomLetter())),
            'owner_name' => fake()->name(),
            'vehicle_model_id' => $vehicleModel ? $vehicleModel->id : null, // Pastikan model kendaraan ada
            'entry_time' => fake()->dateTimeThisYear(),
            'exit_time' => fake()->dateTimeThisYear(),
            'status' => fake()->randomElement(['parked', 'exited']),
        ];
    }
}
