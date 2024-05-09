<?php

use App\Http\Controllers\AparcaController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\espiaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\MapaAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ParkingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

/* Trabajador */

Route::get('/trabajador', [LoginController::class, 'trabajador'])->name('trabajador');

/* Cliente */
Route::get('/reserva', function () {
    return view('reserva');
});


Route::post('/reservaO', [ReservaController::class, 'reservaO'])->name('reservaO');
Route::post('/espia', [espiaController::class, 'espia'])->name('espia');
Route::post('/reserva', [AparcaController::class, 'reserva'])->name('reserva');
Route::get('/aparca', [AparcaController::class, 'aparca'])->name('aparca');
Route::post('/chat', [chatController::class, 'chat'])->name('chat');
Route::get('/chat2', [chatController::class, 'chat2'])->name('chat2');
Route::post('/enviarMen', [chatController::class, 'enviarMen'])->name('enviarMen');

// Route::get('/', function () {return view('reservas');});


Route::post('/mostrar_reservas', [ReservasController::class, 'mostrarR'])->name('mostrarR');
Route::post('/mostrar_reservas_filtro', [ReservasController::class, 'mostrarRFiltro'])->name('mostrarRFiltro');

Route::get('/cambio', function () {
    return view('aparcacoches');
});

Route::get('/info_res', [ReservasController::class, 'info']);






/* Rutas Iker */
/////// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para la página de admin
/////// Mapa
Route::get('/mapa_admin', [MapaAdminController::class, 'index'])->name('mapa_admin');
Route::post('/parking', [MapaAdminController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaAdminController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaAdminController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaAdminController::class, 'destroy'])->name('parking.destroy');
// Route::put('/parking/update-location', [MapaAdminController::class, 'updateLocation'])->name('parking.updateLocation');

// Ruta para actualizar la ubicación de un parking
Route::put('/parking/{id}/update-location', [ParkingController::class, 'updateLocation']);


// Empresa 
Route::get('/empresa', function () {
    return view('empresa.empresa');
})->name('empresa');

use App\Http\Controllers\EmpresaController;

Route::post('/Listarempleados', [EmpresaController::class, 'Listarempleados'])->name('Listarempleados');
Route::post('/registrar', [EmpresaController::class,  'registrar'])->name('registrar');
Route::post('/estado', [EmpresaController::class,  'estado'])->name('estado');
Route::post('/eliminar', [EmpresaController::class, 'eliminar'])->name('eliminar');


// Admin
Route::get('/admin', function () {
    return view('admin.admin');
})->name('admin');

use App\Http\Controllers\AdminGrudController;

Route::post('/listarempresarios', [AdminGrudController::class, 'listarempresarios'])->name('listarempresarios');
Route::post('/adminregistrar', [AdminGrudController::class,  'adminregistrar'])->name('adminregistrar');
Route::post('/admineditar', [AdminGrudController::class,  'admineditar'])->name('adminadmineditar');
Route::post('/admineliminar', [AdminGrudController::class, 'admineliminar'])->name('admineliminar');



// Reservas
Route::get('/gestionreservas', function () {
    return view('empresa.gestionreservas');
})->name('gestionreservas');

use App\Http\Controllers\ReservasGrudController;

Route::post('/listarreservas', [ReservasGrudController::class, 'listarreservas'])->name('listarreservas');
// Route::post('/adminregistrar', [AdminGrudController::class,  'adminregistrar'])->name('adminregistrar');
// Route::post('/admineditar', [AdminGrudController::class,  'admineditar'])->name('adminadmineditar');
// Route::post('/admineliminar', [AdminGrudController::class, 'admineliminar'])->name('admineliminar');

Route::get('/chatG', function () {
    return view('chat');
});
