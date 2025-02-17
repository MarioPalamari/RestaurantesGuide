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
        route::post('/restaurantes/{nombre}', 'inforestaurante')->name('restaurante.ver');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'showAdminDashboard')->name('admin.admin');
        Route::get('/admin/users/index', 'mostrarpagina')->name('admin.users.index');
        Route::get('/datosusuarios', 'index')->name('datosusuarios');
        Route::post('/admin/users/store', 'store')->name('users.store');
        Route::post('/admin/users/update/{user}', 'update')->name('users.update');
        Route::delete('/admin/users/destroy/{user}', 'destroy')->name('users.destroy');
    });
        
    Route::controller(RestaurantesAdminController::class)->group(function () {
        Route::match(['get', 'post'], '/admin-restaurante', 'ShowAdminRestaurantes')->name('admin-restaurante');
        Route::get('/restaurantes/listar', 'listarRestaurantes')->name('restaurantes.listar');
        Route::post('/restaurantes/crear', 'crearRestaurante')->name('restaurantes.crear');
        Route::put('/restaurantes/actualizar/{id}', 'actualizarRestaurante')->name('restaurantes.actualizar');
        Route::delete('/restaurantes/eliminar/{id}', 'eliminarRestaurante')->name('restaurantes.eliminar');
    });
    
});

    // Rutas públicas
    Route::get('/', [RestauranteController::class, 'restaurantesMejorValorados'])->name('dashboard');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/datosusuarios', [AdminController::class, 'index']);
    Route::post('/admin/users/store', [AdminController::class, 'store'])->name('users.store');
    Route::post('/admin/users/update/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/destroy/{user}', [AdminController::class, 'destroy']);
