<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;

route::controller(RestauranteController::class)->group(function () {
    route::get('/', 'restaurantes')->name('restaurantes.restaurantes');
    route::post('/restaurantes/{nombre}', 'inforestaurante')->name('restaurante.ver');
});
