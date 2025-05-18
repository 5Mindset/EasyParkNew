<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition()
    {
        return [
            'plate_number' => strtoupper($this->faker->bothify('N #### ??')),
            'vehicle_model_id' => VehicleModel::inRandomOrder()->first()?->id ?? VehicleModel::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'stnk_image' => 'uploads/stnk/' . $this->faker->uuid . '.jpg',
            'qr_code' => $this->faker->uuid,
        ];
    }
}
