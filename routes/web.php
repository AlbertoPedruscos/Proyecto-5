<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapaGestorController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ReservasGrudController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar la página de inicio de sesión
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Ruta para autenticar al usuario
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para la página de admin
Route::get('/mapa', [MapaGestorController::class, 'index'])->name('mapa');

// Rutas para operaciones CRUD de parkings
Route::post('/parking', [MapaGestorController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaGestorController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaGestorController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaGestorController::class, 'destroy'])->name('parking.destroy');

// Ruta mover parking
Route::post('/parking/update/{id}', [ParkingController::class, 'updateLocation']);

// Ruta página de inicio
Route::get('/', [InicioController::class, 'index'])->name('inicio');


// Rutas Julio
Route::get('/empleados', function () {
    return view('gestion.empleados');
})->name('empleados');


Route::post('/Listarempleados', [EmpresaController::class, 'Listarempleados'])->name('Listarempleados');
Route::post('/registrar', [EmpresaController::class,  'registrar'])->name('registrar');
Route::post('/estado', [EmpresaController::class,  'estado'])->name('estado');
Route::post('/eliminar', [EmpresaController::class, 'eliminar'])->name('eliminar');


// Gestionreservas
Route::get('/gestionreservas', function () {
    return view('gestion.gestionreservas');
})->name('gestionreservas');


<<<<<<< HEAD
// Route::post('/listarreservas', [ReservasGrudController::class, 'listarreservas'])->name('listarreservas');
=======
Route::post('/listarreservas', [ReservasGrudController::class, 'listarreservas'])->name('listarreservas');
Route::post('/CancelarReserva', [ReservasGrudController::class, 'CancelarReserva'])->name('CancelarReserva');
>>>>>>> fe767671c01bc6b5688d0e58c6d76d1471f51dd3
