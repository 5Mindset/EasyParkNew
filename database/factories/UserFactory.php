<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $role = $this->faker->randomElement(['admin', 'petugas', 'mahasiswa']);

        return [
            'full_name' => $fullName = $this->faker->name(),
            'nim' => $this->generateIdentity($role),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // default password
            'phone_number' => '08' . $this->faker->numerify('##########'),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'image' => 'uploads/users/' . $this->faker->uuid . '.jpg',
            'role' => $role,
        ];
    }

    /**
     * Generate NIM or NIP based on role.
     * Return null for admin (nullable string).
     *
     * @param string $role
     * @return string|null
     */
    private function generateIdentity(string $role): ?string
    {
        if ($role === 'mahasiswa') {
            return 'E' . now()->format('Y') . $this->faker->numerify('####');
        } elseif ($role === 'petugas') {
            return $this->faker->numerify('##################'); // 18 digit angka untuk NIP
        } else {
            return null; // Admin tidak punya nim/nip
        }
    }
}
