<?php

namespace Database\Factories;

use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleBrandFactory extends Factory
{
    protected $model = VehicleBrand::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(), // Menghasilkan nama brand acak seperti "Zemlak Group"
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()?->id ?? VehicleType::factory(),
        ];
    }
}
