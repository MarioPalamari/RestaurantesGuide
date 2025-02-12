<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use Illuminate\Database\Seeder;

class restaurantes_Seeder extends Seeder
{
    public function run(): void
    {
        $restaurantes = [
            [
                'nombre' => 'La Parrilla',
                'descripcion' => 'Carnes a la parrilla de primera calidad',
                'precio_medio' => 25.50,
                'img' => 'parrilla.jpg'
            ],
            [
                'nombre' => 'Sushi Master',
                'descripcion' => 'Sushi fresco y auténtico',
                'precio_medio' => 30.00,
                'img' => 'sushi.jpg'
            ],
            [
                'nombre' => 'Pizza Italiana',
                'descripcion' => 'Pizzas al estilo tradicional italiano',
                'precio_medio' => 15.75,
                'img' => 'pizza.jpg'
            ],
            [
                'nombre' => 'Burger House',
                'descripcion' => 'Hamburguesas gourmet con ingredientes premium',
                'precio_medio' => 12.99,
                'img' => 'burger.jpg'
            ],
            [
                'nombre' => 'Veggie World',
                'descripcion' => 'Cocina vegetariana y vegana',
                'precio_medio' => 18.50,
                'img' => 'veggie.jpg'
            ]
        ];

        foreach ($restaurantes as $restaurante) {
            Restaurante::create($restaurante);
        }
    }
} 