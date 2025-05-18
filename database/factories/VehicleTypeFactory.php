<?php

namespace Database\Factories;

use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleTypeFactory extends Factory
{
    protected $model = VehicleType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Motor', 'Mobil']),
            'area_size' => $this->faker->randomFloat(2, 1.5, 3.5), 
        ];
    }
}
