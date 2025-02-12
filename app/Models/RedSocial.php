<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedSocial extends Model
{
    use HasFactory;

    protected $table = 'redes_sociales';

    protected $fillable = [
        'platforma'
    ];

    public function restaurantes()
    {
        return $this->belongsToMany(Restaurante::class, 'restaurante_red_social', 'id_red_social', 'id_restaurante')
                    ->withPivot('url');
    }
}
