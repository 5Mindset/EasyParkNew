<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@polije.ac.id',
                'full_name' => 'Admin Polije',
                'nim' => '12345',
                'password' => 'admin123',
                'role' => 'admin',
            ],
            [
                'email' => 'petugas.parkir@polije.ac.id',
                'full_name' => 'Petugas Parkir',
                'nim' => '54321',
                'password' => 'petugas123',
                'role' => 'petugas',
            ],
            [
                'email' => 'e41230869@student.polije.ac.id',
                'full_name' => 'Alief Ramadhan',
                'nim' => 'E41230869',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ],
            [
                'email' => 'e41232386@student.polije.ac.id',
                'full_name' => 'Alfino Prasetyo',
                'nim' => 'E41232386',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ],
            [
                'email' => 'e41231765@student.polije.ac.id',
                'full_name' => 'Raffi Maulana',
                'nim' => 'E41231765',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ],
            [
                'email' => 'e41231774@student.polije.ac.id',
                'full_name' => 'Raihan Yusuf',
                'nim' => 'E41231774',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ],
            [
                'email' => 'e41232280@student.polije.ac.id',
                'full_name' => 'Arifin Wijaya',
                'nim' => 'E41232280',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'full_name' => $user['full_name'],
                    'name' => explode(' ', $user['full_name'])[0], // generate nama depan
                    'nim' => $user['nim'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                ]
            );
        }
    }
}
