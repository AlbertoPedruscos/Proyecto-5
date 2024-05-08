<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapaAdminController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\InicioController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar la página de inicio de sesión
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Ruta para autenticar al usuario
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Ruta para cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para la página de admin
Route::get('/mapa_admin', [MapaAdminController::class, 'index'])->name('mapa_admin');

// Rutas para operaciones CRUD de parkings
Route::post('/parking', [MapaAdminController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaAdminController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaAdminController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaAdminController::class, 'destroy'])->name('parking.destroy');

// Ruta mover parking
Route::post('/parking/update/{id}', [ParkingController::class, 'updateLocation']);

// Ruta página de inicio
Route::get('/', [InicioController::class, 'index'])->name('inicio');
