<?php

namespace Database\Factories;

use App\Models\GuestVehicle;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GuestVehicleFactory extends Factory
{
    protected $model = GuestVehicle::class;

    public function definition()
    {
        $entry = $this->faker->dateTimeBetween('-1 days', 'now');
        $exit = (clone $entry)->modify('+'.rand(1, 3).' hours');

        return [
            'name' => $this->faker->name(),
            'plate_number' => strtoupper($this->faker->bothify('N #### ??')), // contoh: N 1234 AB
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()?->id ?? VehicleType::factory(),
            'entry_time' => $entry,
            'exit_time' => $this->faker->boolean(70) ? $exit : null, // 70% sudah keluar
            'status' => $this->faker->randomElement(['parked', 'exited']),
        ];
    }
}
