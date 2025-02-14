<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;

// Route::get('/', function () {
//     return view('restaurantes.restaurantes');
// })->name('restaurantes');

route::controller(RestauranteController::class)->group(function () {
    Route::get('/restaurantes', 'mostrarpagina')->name('restaurantes.restaurantes');
    Route::post('/mostrarrestaurantes', 'mostrarrestaurantes')->name('mostrarrestaurantes');
    route::post('/restaurantes/{nombre}', 'inforestaurante')->name('restaurante.ver');
});
