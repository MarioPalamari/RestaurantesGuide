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
    
}
