<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'admin',
            'full_name' => 'Admin User',
            'nim' => 'E20250001',
            'password' => bcrypt('admin123'),
            'phone_number' => '081234567890',
            'address' => 'Jember',
            'date_of_birth' => '2000-01-01',
            'image' => 'uploads/users/admin.png',
            'role' => 'admin',
        ]);

        User::firstOrCreate([
            'email' => 'petugas@example.com',
        ], [
            'name' => 'petugas',
            'full_name' => 'Petugas Parkir',
            'nim' => 'E20250002',
            'password' => bcrypt('petugas123'),
            'phone_number' => '081234567891',
            'address' => 'Kampus Polije',
            'date_of_birth' => '1998-05-12',
            'image' => 'uploads/users/petugas.png',
            'role' => 'petugas',
        ]);

        User::firstOrCreate([
            'email' => 'mahasiswa@example.com',
        ], [
            'name' => 'mahasiswa',
            'full_name' => 'Mahasiswa Polije',
            'nim' => 'E20250003',
            'password' => bcrypt('mahasiswa123'),
            'phone_number' => '081234567892',
            'address' => 'Asrama Polije',
            'date_of_birth' => '2003-08-21',
            'image' => 'uploads/users/mahasiswa.png',
            'role' => 'mahasiswa',
        ]);
    }
}
