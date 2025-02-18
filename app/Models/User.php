<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'id_usuarios');
    }

    public function gerenteRestaurante()
    {
        return $this->hasOne(GerenteRestaurante::class, 'id_usuario');
    }
}
