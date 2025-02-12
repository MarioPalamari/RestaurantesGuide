<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class restaurante_etiqueta_Seeder extends Seeder
{
    public function run(): void
    {
        $etiquetas = [
            ['id_restaurante' => 1, 'id_etiqueta' => 1], // La Parrilla - Carnes
            ['id_restaurante' => 2, 'id_etiqueta' => 2], // Sushi Master - Japonesa
            ['id_restaurante' => 3, 'id_etiqueta' => 3], // Pizza Italiana - Italiana
            ['id_restaurante' => 4, 'id_etiqueta' => 4], // Burger House - Fast Food
            ['id_restaurante' => 5, 'id_etiqueta' => 5]  // Veggie World - Vegana
        ];

        DB::table('restaurante_etiqueta')->insert($etiquetas);
    }
} 