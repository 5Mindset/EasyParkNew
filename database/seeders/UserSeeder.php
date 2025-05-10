<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate([
            'email' => 'admin@polije.ac.id',
        ], [
            'name' => 'admin',
            'nim' => '12345',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Petugas
        User::firstOrCreate([
            'email' => 'petugas.parkir@polije.ac.id',
        ], [
            'name' => 'petugas',
            'nim' => '54321',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        // Mahasiswa 1
        User::firstOrCreate([
            'email' => 'e41230869@student.polije.ac.id',
        ], [
            'name' => 'Alief',
            'nim' => 'E41230869',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);

        // Mahasiswa 2
        User::firstOrCreate([
            'email' => '(e41232386@student.polije.ac.id',
        ], [
            'name' => 'Alfino',
            'nim' => 'E41232386',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);

        // Mahasiswa 3
        User::firstOrCreate([
            'email' => '(e41231765@student.polije.ac.id',
        ], [
            'name' => 'Raffi',
            'nim' => 'E41231765',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);

        // Mahasiswa 4
        User::firstOrCreate([
            'email' => 'e41231774@student.polije.ac.id',
        ], [
            'name' => 'Raihan',
            'nim' => 'E41231774',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);

        // Mahasiswa 5
        User::firstOrCreate([
            'email' => 'e41232280@student.polije.ac.id',
        ], [
            'name' => 'Arifin',
            'nim' => 'E41232280',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);
    }
}
