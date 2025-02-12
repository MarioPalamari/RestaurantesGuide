<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'valoracion',
        'comentario',
        'id_usuarios',
        'id_restaurante'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuarios');
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }
}
