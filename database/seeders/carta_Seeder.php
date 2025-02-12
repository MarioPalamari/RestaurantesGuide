<?php

namespace Database\Seeders;

use App\Models\Carta;
use Illuminate\Database\Seeder;

class carta_Seeder extends Seeder
{
    public function run(): void
    {
        $platos = [
            [
                'nombre' => 'Entrecot',
                'descripcion' => 'Entrecot de ternera a la parrilla',
                'precio' => 22.50,
                'id_restaurante' => 1
            ],
            [
                'nombre' => 'Sushi Variado',
                'descripcion' => 'Selección de 12 piezas de sushi',
                'precio' => 18.00,
                'id_restaurante' => 2
            ],
            [
                'nombre' => 'Pizza Margarita',
                'descripcion' => 'Pizza clásica con tomate y mozzarella',
                'precio' => 10.50,
                'id_restaurante' => 3
            ],
            [
                'nombre' => 'Burger Clásica',
                'descripcion' => 'Hamburguesa con queso, lechuga y tomate',
                'precio' => 9.99,
                'id_restaurante' => 4
            ],
            [
                'nombre' => 'Ensalada Vegana',
                'descripcion' => 'Ensalada con quinoa y vegetales frescos',
                'precio' => 12.00,
                'id_restaurante' => 5
            ]
        ];

        foreach ($platos as $plato) {
            Carta::create($plato);
        }
    }
} 