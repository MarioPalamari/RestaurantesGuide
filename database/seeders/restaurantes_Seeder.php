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
                'img' => 'parrilla.jpg',
                'lugar' => 'Carrer de Salamanca, 1, Ciutat Vella, 08003 Barcelona',
                'horario' => '9:00 - 21:00',
                'contacto' => '692953216',
                'web' => 'https://www.thefork.es/'
            ],
            [
                'nombre' => 'Sushi Master',
                'descripcion' => 'Sushi fresco y auténtico',
                'precio_medio' => 30.00,
                'img' => 'sushi.jpg',
                'lugar' => 'Ctra. de Pozuelo, 48, 28222 Majadahonda, Madrid',
                'horario' => '9:00 - 21:00',
                'contacto' => '910164431',
                'web' => 'https://www.sushimaster.net/'
            ],
            [
                'nombre' => 'Pizza Italiana',
                'descripcion' => 'Pizzas al estilo tradicional italiano',
                'precio_medio' => 15.75,
                'img' => 'pizza.jpg',
                'lugar' => "Pizza Energia, Carrer de l'Arquitectura, 32, 08908 L'Hospitalet de Llobregat, Barcelona",
                'horario' => '9:00 - 21:00',
                'contacto' => '933321245',
                'web' => 'http://pizzaenergia.es/'
            ],
            [
                'nombre' => 'Burger House',
                'descripcion' => 'Hamburguesas gourmet con ingredientes premium',
                'precio_medio' => 12.99,
                'img' => 'burger.jpg',
                'lugar' => 'Carrer de Baltasar Oriol i Mercer, 68, 08940 Cornellà de Llobregat, Barcelona',
                'horario' => '9:00 - 21:00',
                'contacto' => '930232363',
                'web' => ''
            ],
            [
                'nombre' => 'Veggie World',
                'descripcion' => 'Cocina vegetariana y vegana',
                'precio_medio' => 18.50,
                'img' => 'veggie.jpg',
                'lugar' => 'Carrer de Bruniquer, 24, Gràcia, 08012 Barcelona',
                'horario' => '9:00 - 21:00',
                'contacto' => '932107056',
                'web' => 'https://www.vegworld.es/'
            ]
        ];

        foreach ($restaurantes as $restaurante) {
            Restaurante::create($restaurante);
        }
    }
}
