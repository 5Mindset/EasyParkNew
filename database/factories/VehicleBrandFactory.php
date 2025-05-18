<?php

namespace Database\Factories;

use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleBrandFactory extends Factory
{
    protected $model = VehicleBrand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'Honda', 'Yamaha', 'Suzuki', 'Kawasaki', // motor
                'Toyota', 'Daihatsu', 'Mitsubishi', 'Nissan', 'Hyundai' // mobil
            ]),
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()?->id ?? VehicleType::factory(),
        ];
    }
}
