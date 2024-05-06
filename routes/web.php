<?php

use App\Http\Controllers\AparcaController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\espiaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\MapaAdminController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

/* Trabajador */
Route::get('/trabajador', function () {
    return view('trabajador');
});

Route::post('/trabajador', [LoginController::class, 'authenticate'])->name('login.post');


/* Cliente */
Route::get('/reserva', function () {
    return view('reserva');
});

Route::post('/reserva', [LoginController::class, 'authenticate'])->name('login.post');

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






/* Rutas Iker */
/////// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Ruta para la página de admin
/////// Mapa
Route::get('/mapa_admin', [MapaAdminController::class, 'index'])->name('mapa_admin');
Route::post('/parking', [MapaAdminController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaAdminController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaAdminController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaAdminController::class, 'destroy'])->name('parking.destroy');
