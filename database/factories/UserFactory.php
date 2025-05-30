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
        $fullName = $this->faker->name();
        $name = explode(' ', $fullName)[0]; // nama depan

        return [
            'full_name'     => $fullName,
            'name'          => $name,
            'nim'           => $this->generateIdentity($role),
            'email'         => $this->faker->unique()->safeEmail(),
            'password'      => bcrypt('password'), // default password
            'phone_number'  => '08' . $this->faker->numerify('##########'),
            'address'       => $this->faker->address(),
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'image'         => 'uploads/users/' . $this->faker->uuid . '.jpg',
            'role'          => $role,
        ];
    }

    /**
     * Generate NIM or NIP based on role.
     * Return default format for admin to avoid null errors.
     *
     * @param string $role
     * @return string
     */
    private function generateIdentity(string $role): string
    {
        if ($role === 'mahasiswa') {
            return 'E' . now()->format('Y') . $this->faker->numerify('####');
        } elseif ($role === 'petugas') {
            return $this->faker->numerify('##################'); // 18 digit angka
        } else {
            return 'ADM' . $this->faker->numerify('#####'); // default untuk admin
        }
    }
}
