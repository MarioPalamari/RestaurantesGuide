<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AdminController;

// Ruta raíz para el Dashboard (solo accesible cuando el usuario esté autenticado)
Route::middleware(['auth'])->group(function () {    
    // Rutas de restaurantes, dentro del middleware de autenticación
    Route::controller(RestauranteController::class)->group(function () {
        Route::get('/restaurantes', 'restaurantes')->name('restaurantes.restaurantes');
        Route::post('/restaurantes/{nombre}', 'inforestaurante')->name('restaurante.ver');
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'ShowAdminDashboard')->name('admin.admin');
    });
});



Route::get('/', [RestauranteController::class, 'restaurantesMejorValorados'])->name('dashboard');

// Rutas públicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
