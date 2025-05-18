<?php

namespace Database\Factories;

use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleModelFactory extends Factory
{
    protected $model = VehicleModel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->bothify('Model-###'), 
            'vehicle_brand_id' => VehicleBrand::inRandomOrder()->first()?->id ?? VehicleBrand::factory(),
        ];
    }
}
