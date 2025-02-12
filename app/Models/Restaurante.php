<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    protected $table = 'restaurantes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_medio',
        'img'
    ];

    public function cartas()
    {
        return $this->hasMany(Carta::class, 'id_restaurante');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'id_restaurante');
    }

    public function redesSociales()
    {
        return $this->belongsToMany(RedSocial::class, 'restaurante_red_social', 'id_restaurante', 'id_red_social')
                    ->withPivot('url');
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'restaurante_etiqueta', 'id_restaurante', 'id_etiqueta');
    }
}
