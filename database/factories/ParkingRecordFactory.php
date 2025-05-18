<?php

namespace Database\Factories;

use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingRecordFactory extends Factory
{
    protected $model = ParkingRecord::class;

    public function definition()
    {
        $entry = $this->faker->dateTimeBetween('-2 days', 'now');
        $hasExited = $this->faker->boolean(70); 

        return [
            'vehicle_id' => Vehicle::inRandomOrder()->first()?->id ?? Vehicle::factory(),
            'entry_time' => $entry,
            'exit_time' => $hasExited ? (clone $entry)->modify('+'.rand(1, 5).' hours') : null,
            'status' => $hasExited ? 'keluar' : 'masuk',
        ];
    }
}
