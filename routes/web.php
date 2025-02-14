<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;

// Route::get('/', function () {
//     return view('restaurantes.restaurantes');
// })->name('restaurantes');



Route::middleware(['auth'])->group(function () {    
    // Rutas de restaurantes, dentro del middleware de autenticación
    route::controller(RestauranteController::class)->group(function () {
        route::get('/restaurantes', 'restaurantes')->name('restaurantes.restaurantes');
        route::post('/restaurantes/{nombre}', 'inforestaurante')->name('restaurante.ver');
    });
});
Route::get('/', [RestauranteController::class, 'restaurantesMejorValorados'])->name('dashboard');

// Rutas públicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
