<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

route::controller(RestauranteController::class)->group(function () {
    route::get('/', 'restaurantes')->name('restaurantes.restaurantes');
    route::post('/restaurantes/{nombre}', 'inforestaurante')->name('restaurante.ver');
});
