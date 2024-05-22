<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapaGestorController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ReservasGrudController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EmpleadosController;


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


// Reservas
Route::get('/reservas', function () {
    return view('gestion.reservas');
})->name('reservas');


Route::post('/listarreservas', [ReservasGrudController::class, 'listarreservas'])->name('listarreservas');



// Formulario reserva
Route::post('/reservaO', [ReservaController::class, 'reservaO'])->name('reservaO');




/* Gestión empleados prueba Iker */
Route::get('/gestEmpleados', [EmpleadosController::class, 'index'])->name('gestEmpleados'); // Mostrar todos los empleados
Route::post('/empleado/store', [EmpleadosController::class, 'store'])->name('empleado.store'); // Registrar
Route::get('/empleado/{id}/edit', [EmpleadosController::class, 'edit'])->name('empleado.edit'); // Editar un empleado
Route::put('/empleado/update/{id}', [EmpleadosController::class, 'update'])->name('empleado.update'); // Actualizar datos de un empleado
Route::delete('/empleado/destroy/{id}', [EmpleadosController::class, 'destroy'])->name('empleado.destroy'); // Eliminar un empleado
// Route::get('/empleado/buscar', [EmpleadosController::class, 'buscarEmpleado'])->name('empleado.buscar');


// Info de los registros
Route::get('/registros', function () {
    return view('gestion.registros');
})->name('registros');

// Info de los registros
Route::get('/contactanos', function () {
    return view('vistas.contactanos');
})->name('contactanos');