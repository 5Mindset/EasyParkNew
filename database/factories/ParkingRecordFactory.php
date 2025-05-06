<?php

namespace Database\Factories;

use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'entry_time' => $this->faker->dateTimeThisYear(),
            'exit_time' => $this->faker->dateTimeThisYear(),
            'status' => $this->faker->randomElement(['parked', 'exited']), // Pilih status yang valid
        ];
    }
}
