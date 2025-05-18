<?php
namespace Database\Factories;

use App\Models\GuestVehicle;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GuestVehicleFactory extends Factory
{
    protected $model = GuestVehicle::class;

    public function definition(): array
    {
        $vehicleType = VehicleType::inRandomOrder()->first();

        return [
            'plate_number' => strtoupper('N ' . fake()->unique()->numberBetween(1000, 9999) . ' ' . Str::upper(fake()->randomLetter()) . Str::upper(fake()->randomLetter())),
            'owner_name' => fake()->name(),
            'vehicle_type_id' => $vehicleType?->id ?? 1, // fallback jika kosong
            'entry_time' => fake()->dateTimeThisYear(),
            'exit_time' => fake()->boolean(30) ? fake()->dateTimeThisYear() : null,
            'status' => fake()->randomElement(['parked', 'exited']),
        ];
    }
}

