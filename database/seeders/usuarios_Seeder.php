<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class usuarios_Seeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'nombre' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('qweQWE123'),
                'rol_id' => 1
            ],
            [
                'nombre' => 'Usuario1',
                'email' => 'usuario1@example.com',
                'password' => Hash::make('qweQWE123'),
                'rol_id' => 2
            ],
            [
                'nombre' => 'Moderador1',
                'email' => 'moderador1@example.com',
                'password' => Hash::make('qweQWE123'),
                'rol_id' => 3
            ],
            [
                'nombre' => 'Invitado1',
                'email' => 'invitado1@example.com',
                'password' => Hash::make('qweQWE123'),
                'rol_id' => 4
            ],
            [
                'nombre' => 'Editor1',
                'email' => 'editor1@example.com',
                'password' => Hash::make('qweQWE123'),
                'rol_id' => 5
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
} 