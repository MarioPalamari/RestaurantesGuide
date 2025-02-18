<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class restaurante_red_social extends Model
{
    protected $table = 'restaurante_red_social';

    protected $fillable = [
        'id_restaurante',
        'id_red_social',
        'url'
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }
}
