<?php

use App\Http\Controllers\AparcaController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\espiaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\MapaAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/trabajador', function () {
    return view('reservas');
});

Route::get('/cliente', function () {
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

/* Rutas Iker */
Route::get('/login', function () {return view('auth.login');})->name('login');
// Ruta para la página de admin
Route::get('/mapa_admin', [MapaAdminController::class, 'index'])->name('mapa_admin');

// Rutas para operaciones CRUD de parkings
Route::post('/parking', [MapaAdminController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaAdminController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaAdminController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaAdminController::class, 'destroy'])->name('parking.destroy');
