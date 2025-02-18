<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            roles_Seeder::class,
            etiquetas_Seeder::class,
            redes_sociales_Seeder::class,
            restaurantes_Seeder::class,
            usuarios_Seeder::class,
            carta_Seeder::class,
            valoraciones_Seeder::class,
            restaurante_red_social_Seeder::class,
            restaurante_etiqueta_Seeder::class,
            GerenteRestauranteSeeder::class
        ]);
    }
}
