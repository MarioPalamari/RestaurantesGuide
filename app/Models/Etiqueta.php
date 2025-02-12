<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $table = 'etiquetas';

    protected $fillable = [
        'nombre'
    ];

    public function restaurantes()
    {
        return $this->belongsToMany(Restaurante::class, 'restaurante_etiqueta', 'id_etiqueta', 'id_restaurante');
    }
}
