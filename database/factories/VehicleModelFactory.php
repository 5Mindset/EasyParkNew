<?php

namespace Database\Factories;

use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleModelFactory extends Factory
{
    protected $model = VehicleModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'vehicle_brand_id' => VehicleBrand::inRandomOrder()->first()?->id ?? VehicleBrand::factory(),
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()?->id ?? VehicleType::factory(),
        ];
    }
}
