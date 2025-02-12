<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class roles_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Usuario'],
            ['nombre' => 'Moderador'],
            ['nombre' => 'Invitado'],
            ['nombre' => 'Editor']
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
