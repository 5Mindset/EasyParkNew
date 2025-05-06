<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'name' => $this->faker->userName(), // atau gunakan sesuai kebutuhan
            'nim' => 'E' . $this->faker->unique()->numerify('2025####'),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone_number' => $this->faker->unique()->numerify('08##########'),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->date('Y-m-d', '2005-01-01'),
            'image' => 'uploads/users/default.png',
            'role' => $this->faker->randomElement(['admin', 'petugas', 'mahasiswa']),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
