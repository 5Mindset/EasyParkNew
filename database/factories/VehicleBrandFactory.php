<?php

namespace Database\Factories;

use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleBrandFactory extends Factory
{
    protected $model = VehicleBrand::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'Toyota',
                'Daihatsu', 'Mitsubishi', 'Nissan', 'Wuling', 'Isuzu'
            ]),
        ];
    }
}
