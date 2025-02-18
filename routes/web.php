<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RestaurantesAdminController;
// Route::get('/', function () {
//     return view('restaurantes.restaurantes');
// })->name('restaurantes');
Route::middleware(['auth'])->group(function () {
    // Rutas de restaurantes, dentro del middleware de autenticación
    route::controller(RestauranteController::class)->group(function () {
        Route::get('/restaurantes', 'mostrarpagina')->name('restaurantes.restaurantes');
        Route::post('/mostrarrestaurantes', 'mostrarrestaurantes')->name('mostrarrestaurantes');
        route::post('/restaurantes/{nombre}', 'mostrarpaginarestaurante')->name('restaurante.ver');
        route::get('/restaurantes/{nombre}', 'mostrarpaginarestaurante')->name('restaurante.ver');
        route::post('/opinar', 'opinarform');
        Route::post('/mostrarinforestaurante', 'mostrarinforestaurante');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'showAdminDashboard')->name('admin.admin');
        Route::get('/admin/users/index', 'mostrarpagina')->name('admin.users.index');
        Route::get('/datosusuarios', 'index');
        Route::post('/admin/users/store', 'store')->name('users.store');
        Route::post('/admin/users/update/{user}', 'update')->name('users.update');
        Route::delete('/admin/users/destroy/{user}', 'destroy')->name('users.destroy');
    });
        
    Route::controller(RestaurantesAdminController::class)->group(function () {
        Route::match(['get', 'post'], '/admin-restaurante', 'ShowAdminRestaurantes')->name('admin-restaurante');
        Route::get('/restaurantes-admin/listar', 'listarRestaurantes')->name('restaurantes.listar');
        Route::post('/restaurantes-admin/crear', 'crearRestaurante')->name('restaurantes.crear');
        Route::post('/restaurantes-admin/actualizar/{id}', [RestaurantesAdminController::class, 'actualizarRestaurante'])->name('restaurantes.actualizar');
        Route::delete('/restaurantes-admin/eliminar/{id}', 'eliminarRestaurante')->name('restaurantes.eliminar');
        Route::get('/restaurantes-admin/listar/{id}', [RestaurantesAdminController::class, 'mostrarRestaurante'])->name('restaurantes.show');
    });
    
});

    // Rutas públicas
    Route::get('/', [RestauranteController::class, 'restaurantesMejorValorados'])->name('dashboard');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [RestauranteController::class, 'restaurantesMejorValorados'])->name('dashboard');

// Rutas públicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');