<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'plate_number' => strtoupper($this->faker->bothify('N #### ??')),
            'vehicle_model_id' => VehicleModel::inRandomOrder()->value('id') ?? VehicleModel::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'stnk_image' => 'uploads/stnk/default.png',
            'qr_code' => $this->faker->uuid,
        ];
    }
}
