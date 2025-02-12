<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class etiquetas_Seeder extends Seeder
{
    public function run(): void
    {
        $etiquetas = [
            ['nombre' => 'Carnes'],
            ['nombre' => 'Japonesa'],
            ['nombre' => 'Italiana'],
            ['nombre' => 'Fast Food'],
            ['nombre' => 'Vegana']
        ];

        foreach ($etiquetas as $etiqueta) {
            Etiqueta::create($etiqueta);
        }
    }
} 