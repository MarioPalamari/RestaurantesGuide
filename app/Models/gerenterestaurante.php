<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gerenterestaurante extends Model
{
    protected $table = 'gerente_restaurante';

    protected $fillable = [
        'id_usuario',
        'id_restaurante'
    ];
    
    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }
}
