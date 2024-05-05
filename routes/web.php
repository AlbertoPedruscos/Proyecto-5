<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapaAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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


// Ruta para la página de usuario
Route::get('/usuario', function () {
    return view('vistas.usuario');
})->name('usuario');

// Ruta para la página de empresa
Route::get('/empresa', function () {
    return view('vistas.empresa');
})->name('empresa');


// Ruta para la página admin mapa
Route::get('/mapa_admin', [MapaAdminController::class, 'index'])->name('mapa_admin');

Route::post('/parking', [MapaAdminController::class, 'store'])->name('parking.post');

Route::middleware(['web'])->group(function () {
    Route::delete('/parking/{id}', [MapaAdminController::class, 'destroy'])->name('parking.destroy');
});

Route::get('/parking/{id}', [MapaAdminController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaAdminController::class, 'update'])->name('parking.update');
