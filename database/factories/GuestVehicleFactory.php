<?php

namespace Database\Factories;

use App\Models\GuestVehicle;
use App\Models\VehicleType;
use App\Models\ParkingArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GuestVehicleFactory extends Factory
{
    protected $model = GuestVehicle::class;

    public function definition()
    {
        $entry = $this->faker->dateTimeBetween('-1 days', 'now');
        $exit = (clone $entry)->modify('+' . rand(1, 3) . ' hours');

        return [
            'name' => $this->faker->name(),
            'plate_number' => strtoupper($this->faker->bothify('N #### ??')), // contoh: N 1234 AB
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()?->id ?? VehicleType::factory(),
            'parking_area_id' => ParkingArea::inRandomOrder()->first()?->id ?? ParkingArea::factory(), // Tambahan ini
            'entry_time' => $entry,
            'exit_time' => $this->faker->boolean(70) ? $exit : null, // 70% sudah keluar
            'status' => $this->faker->randomElement(['parked', 'exited']),
        ];
    }
}
