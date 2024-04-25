<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
Route::get('/admin', function () {
    return view('vistas.admin');
})->name('admin');

// Ruta para la página de usuario
Route::get('/usuario', function () {
    return view('vistas.usuario');
})->name('usuario');

// Ruta para la página de empresa
Route::get('/empresa', function () {
    return view('vistas.empresa');
})->name('empresa');
