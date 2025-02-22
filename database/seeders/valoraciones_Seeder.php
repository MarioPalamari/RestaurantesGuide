<?php

namespace Database\Seeders;

use App\Models\Valoracion;
use Illuminate\Database\Seeder;

class valoraciones_Seeder extends Seeder
{
    public function run(): void
    {
        $valoraciones = [
            [
                'valoracion' => 5.0,
                'comentario' => 'Excelente comida y servicio',
                'id_usuarios' => 2,
                'id_restaurante' => 1
            ],
            [
                'valoracion' => 5.0,
                'comentario' => 'El mejor sushi que he probado',
                'id_usuarios' => 2,
                'id_restaurante' => 2
            ],
            [
                'valoracion' => 4.0,
                'comentario' => 'Buena pizza, pero esperaba más',
                'id_usuarios' => 2,
                'id_restaurante' => 3
            ],
            [
                'valoracion' => 4.0,
                'comentario' => 'Hamburguesas jugosas y sabrosas',
                'id_usuarios' => 2,
                'id_restaurante' => 4
            ],
            [
                'valoracion' => 4.0,
                'comentario' => 'Opción perfecta para veganos',
                'id_usuarios' => 2,
                'id_restaurante' => 5
            ]
        ];

        foreach ($valoraciones as $valoracion) {
            Valoracion::create($valoracion);
        }
    }
} 