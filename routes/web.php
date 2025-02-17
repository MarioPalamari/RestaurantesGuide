<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AdminController;


// Route::get('/', function () {
//     return view('restaurantes.restaurantes');
// })->name('restaurantes');
Route::middleware(['auth'])->group(function () {
    // Rutas de restaurantes, dentro del middleware de autenticación
    route::controller(RestauranteController::class)->group(function () {
        Route::get('/restaurantes', 'mostrarpagina')->name('restaurantes.restaurantes');
        Route::post('/mostrarrestaurantes', 'mostrarrestaurantes')->name('mostrarrestaurantes');
        route::post('/restaurantes/{nombre}', 'mostrarpaginarestaurante')->name('restaurante.ver');
        route::post('/opinar', 'opinarform');
        Route::post('/mostrarinforestaurante', 'mostrarinforestaurante');
    });
        // Route::get('/admin-restaurantes','ShowAdminRestaurantes')->name('RestaurantesAdmin');
        Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'showAdminDashboard')->name('admin.admin');
        Route::get('/admin/users/index', 'mostrarpagina')->name('admin.users.index');
        Route::get('/datosusuarios', 'index');
        Route::post('/admin/users/store', 'store')->name('users.store');
        Route::post('/admin/users/update/{user}', 'update')->name('users.update');
        Route::delete('/admin/users/destroy/{user}', 'destroy')->name('users.destroy');
    });
        

});



Route::get('/', [RestauranteController::class, 'restaurantesMejorValorados'])->name('dashboard');

// Rutas públicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);