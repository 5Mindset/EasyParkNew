<?php

namespace Database\Factories;

use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleTypeFactory extends Factory
{
    protected $model = VehicleType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(), // nama acak unik, misalnya 'zenta', 'novix'
            'area_size' => $this->faker->randomFloat(2, 1.0, 5.0), // angka desimal acak 1.00–5.00
        ];
    }
}
