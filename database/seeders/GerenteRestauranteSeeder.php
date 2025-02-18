<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\gerenterestaurante;

class GerenteRestauranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $valoraciones = [
            [
                'id_usuario' => 1,
                'id_restaurante' => 1,
            ],
            [
                'id_usuario' => 2,
                'id_restaurante' => 2,
            ],
            [
                'id_usuario' => 3,
                'id_restaurante' => 3,
            ],
        ];

        foreach ($valoraciones as $valoracion) {
            gerenterestaurante::create($valoracion);
        }
    }
}
