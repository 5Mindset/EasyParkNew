<?php

namespace Database\Factories;

use App\Models\ParkingArea;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingAreaFactory extends Factory
{
    protected $model = ParkingArea::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Gedung A', 'Gedung B', 'Fakultas Teknik', 'Fakultas Ekonomi',
                'Parkiran Utama', 'Parkiran Belakang'
            ]),
            'max_area' => $this->faker->randomFloat(2, 300, 1000), // 300.00 - 1000.00
        ];
    }
}
