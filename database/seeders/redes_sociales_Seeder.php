<?php

namespace Database\Seeders;

use App\Models\RedSocial;
use Illuminate\Database\Seeder;

class redes_sociales_Seeder extends Seeder
{
    public function run(): void
    {
        $redes = [
            ['platforma' => 'Facebook'],
            ['platforma' => 'Instagram'],
            ['platforma' => 'Twitter'],
            ['platforma' => 'TikTok'],
            ['platforma' => 'YouTube']
        ];

        foreach ($redes as $red) {
            RedSocial::create($red);
        }
    }
} 