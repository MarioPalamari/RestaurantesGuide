<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class restaurante_red_social_Seeder extends Seeder
{
    public function run(): void
    {
        $redes = [
            [
                'id_restaurante' => 1,
                'id_red_social' => 1,
                'url' => 'https://facebook.com/laparrilla'
            ],
            [
                'id_restaurante' => 2,
                'id_red_social' => 2,
                'url' => 'https://instagram.com/sushimaster'
            ],
            [
                'id_restaurante' => 3,
                'id_red_social' => 3,
                'url' => 'https://twitter.com/pizzaitaliana'
            ],
            [
                'id_restaurante' => 4,
                'id_red_social' => 4,
                'url' => 'https://tiktok.com/burgerhouse'
            ],
            [
                'id_restaurante' => 5,
                'id_red_social' => 5,
                'url' => 'https://youtube.com/veggieworld'
            ]
        ];

        DB::table('restaurante_red_social')->insert($redes);
    }
} 