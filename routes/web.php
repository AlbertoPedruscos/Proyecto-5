<?php

use App\Http\Controllers\AparcaController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\espiaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\MapaAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\entregaController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\MapaGestorController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ReservasGrudController;
use App\Http\Controllers\ColaController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\AdminGrudController;
use App\Http\Controllers\enviarFotos;
use App\Http\Controllers\hacerUbis;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UbicacionesController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('vistas.pagos');
// });

Route::get('/yes', function () {
    return view('vistas.crearUbi');
});

Route::get('/cola', function () {
    return view('vistas.cola');
})->name('cola');
Route::post('/upload', [ColaController::class, 'uploadFiles'])->name('cola');

// Ruta para mostrar la página de inicio de sesión
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Ruta para autenticar al usuario
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/galeria', [enviarFotos::class, 'obtenerRutasDeImagenes'])->name('galeria');

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

Route::post('processPayment', [PaymentController::class, 'processPayment'])->name('processPayment');
// Route::post('/procesar-pago', [PaymentController::class, 'procesarPago'])->name('procesar-pago');


Route::post('/Listarempleados', [EmpresaController::class, 'Listarempleados'])->name('Listarempleados');
Route::post('/registrar', [EmpresaController::class,  'registrar'])->name('registrar');
Route::post('/estado', [EmpresaController::class,  'estado'])->name('estado');
Route::post('/eliminar', [EmpresaController::class, 'eliminar'])->name('eliminar');


// Reservas
Route::get('/reservas', function () {
    return view('gestion.reservas');
})->name('reservas');

Route::post('/listarreservas', [ReservasGrudController::class, 'listarreservas'])->name('listarreservas');
Route::post('/ReservasEditar', [ReservasGrudController::class, 'ReservasEditar'])->name('ReservasEditar');
Route::post('/CancelarReserva', [ReservasGrudController::class, 'CancelarReserva'])->name('CancelarReserva');
Route::get('/listarreservascsv', [ReservasGrudController::class, 'listarreservascsv']);




// Formulario reserva
Route::post('/reservaO', [ReservaController::class, 'reservaO'])->name('reservaO');
// Formulario Contactacnos
Route::post('/Contactanos', [ReservaController::class, 'Contactanos'])->name('Contactanos');

Route::get('/contactar', function () {
    return view('vistas.contactanos');
});

/* Trabajador */

// Route::get('/trabajador', [LoginController::class, 'trabajador'])->name('trabajador');
Route::get('/trabajador', function () {
    return view('vistas.trabajador');
});

Route::get('/mapasA', function () {
    return view('vistas.mapaAparca');
});

Route::get('/mapasA2', function () {
    return view('vistas.mapaAparca2');
});


/* Cliente */
Route::get('/reserva', function () {
    return view('vistas.reserva');
});

Route::get('/devolucion', function () {
    return view('vistas.devolucion');
});

Route::post('/confirmar-entrega', [entregaController::class, 'confirmarEntrega'])->name('reservaO');
Route::post('/codigoSal', [entregaController::class, 'codigoSal'])->name('codigoSal');

Route::post('/reservaO', [ReservaController::class, 'reservaO'])->name('reservaO');

Route::post('/espia', [espiaController::class, 'espia'])->name('espia');
Route::post('/espia2', [espiaController::class, 'espia2'])->name('espia2');
Route::post('/notaR', [espiaController::class, 'notaR'])->name('notaR');

Route::post('/reservaA', [AparcaController::class, 'reservaA'])->name('reservaA');
Route::get('/aparca', [AparcaController::class, 'aparca'])->name('aparca');
Route::get('/mapaT', [AparcaController::class, 'mapaT'])->name('mapaT');

Route::post('/chat', [chatController::class, 'chat'])->name('chat');
Route::get('/chat2', [chatController::class, 'chat2'])->name('chat2');
Route::post('/menCor', [chatController::class, 'menCor'])->name('menCor');
Route::get('/menCor2', [chatController::class, 'menCor2'])->name('menCor2');
Route::post('/enviarMen', [chatController::class, 'enviarMen'])->name('enviarMen');
Route::post('/eliminarUbica', [hacerUbis::class, 'eliminarUbica'])->name('eliminarUbica');
Route::post('/editarUbicacion', [hacerUbis::class, 'editarUbicacion'])->name('editarUbicacion');
Route::post('/buscarUbicaciones', [hacerUbis::class, 'buscarUbicaciones'])->name('buscarUbicaciones');
Route::post('/agregarUbicacion', [hacerUbis::class, 'masUbi'])->name('masUbis');
Route::post('/subirImagenes', [enviarFotos::class, 'subirImagenes'])->name('subirImagenes');

// Route::get('/', function () {return view('reservas');});


Route::post('/mostrar_reservas', [ReservasController::class, 'mostrarR'])->name('mostrarR');
Route::post('/filtroubi', [ReservasController::class, 'filtroUbi'])->name('filtroUbi');
Route::post('/mostrar_reservas_filtro', [ReservasController::class, 'mostrarRFiltro'])->name('mostrarRFiltro');

Route::get('/cambio', function () {
    return view('vistas.aparcacoches');
});

Route::get('/info_res', [ReservasController::class, 'info']);

Route::post('/escogerP', [ReservasController::class, 'escogerP'])->name('escogerP');

Route::post('/confirmar-entrega', [entregaController::class, 'confirmarEntrega'])->name('reservaO');





/* IKER */
Route::get('/gestEmpleados', [EmpleadosController::class, 'index'])->name('gestEmpleados'); // Mostrar todos los empleados
Route::post('/empleado/store', [EmpleadosController::class, 'store'])->name('empleado.store'); // Registrar
Route::get('/empleado/{id}/edit', [EmpleadosController::class, 'edit'])->name('empleado.edit'); // Editar un empleado
Route::put('/empleado/update/{id}', [EmpleadosController::class, 'update'])->name('empleado.update'); // Actualizar datos de un empleado
Route::delete('/empleado/destroy/{id}', [EmpleadosController::class, 'destroy'])->name('empleado.destroy'); // Eliminar un empleado

/* Rutas para el historial */
Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
Route::post('/historial/buscar', [HistorialController::class, 'buscarHistorial'])->name('historial.buscar');
Route::get('/actualizar-tabla', 'HistorialController@actualizarTabla')->name('actualizar.tabla');

// Ruta para la página de admin
Route::get('/mapa', [MapaGestorController::class, 'index'])->name('mapa');

// Rutas para operaciones CRUD de parkings
Route::post('/parking', [MapaGestorController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaGestorController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaGestorController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaGestorController::class, 'destroy'])->name('parking.destroy');

/////// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para actualizar la ubicación de un parking
Route::put('/parking/{id}/update-location', [ParkingController::class, 'updateLocation']);

Route::get('/actualizar-tabla', [HistorialController::class, 'actualizarTabla'])->name('actualizar.tabla');

Route::put('/parking/{id}/update-location', [ParkingController::class, 'updateLocation']);

Route::get('/gestion.plazasParking', [ParkingController::class, 'showPlazas'])->name('plazasParking.show');

Route::get('/plazasParking', [ParkingController::class, 'showPlazas'])->name('plazasParking');

// Empresa 
Route::get('/empresa', function () {
    return view('empresa.empresa');
})->name('empresa');

Route::post('/Listarempleados', [EmpresaController::class, 'Listarempleados'])->name('Listarempleados');
Route::post('/registrar', [EmpresaController::class,  'registrar'])->name('registrar');
Route::post('/estado', [EmpresaController::class,  'estado'])->name('estado');
Route::post('/eliminar', [EmpresaController::class, 'eliminar'])->name('eliminar');


// VISTA ADMIN -> GESTORES DE LAS EMPRESAS
Route::get('/admin', function () {
    return view('admin.admin');
})->name('admin');

Route::post('/empresa/store', [AdminGrudController::class, 'store'])->name('empresa.store'); // Registrar Empresa

// Rutas para las acciones de CRUD
Route::post('/adminclientes', [AdminGrudController::class, 'adminclientes'])->name('adminclientes');
Route::post('/adminregistrar', [AdminGrudController::class, 'adminregistrar'])->name('adminregistrar');
Route::post('/admineditar', [AdminGrudController::class, 'admineditar'])->name('admineditar'); // corregido el nombre de la ruta
Route::post('/admineliminar', [AdminGrudController::class, 'admineliminar'])->name('admineliminar');

// VISTA ADMIN -> EMPRESAS
// Ruta para la vista principal de admin_empresa
Route::get('/admin_empresa', function () {
    return view('admin.admin_empresa');
})->name('admin_empresa');

Route::post('/admin_empresa', function () {
    return response()->json(['message' => 'POST request handled successfully']);
})->name('admin_empresa_post');

// Rutas POST para las operaciones de CRUD en empresas
Route::post('/adminempresas', [AdminGrudController::class, 'adminempresas'])->name('adminempresas');
Route::post('/adminempresasregistrar', [AdminGrudController::class, 'adminempresasregistrar'])->name('adminempresasregistrar');
Route::post('/adminempresaseditar', [AdminGrudController::class, 'adminempresaseditar'])->name('adminempresaseditar');
Route::post('/adminempresaseliminar', [AdminGrudController::class, 'adminempresaseliminar'])->name('adminempresaseliminar');

Route::post('/listarempresarios', [AdminGrudController::class, 'listarempresarios'])->name('listarempresarios');
Route::post('/adminregistrar', [AdminGrudController::class,  'adminregistrar'])->name('adminregistrar');
Route::post('/admineditar', [AdminGrudController::class,  'admineditar'])->name('adminadmineditar');
Route::post('/admineliminar', [AdminGrudController::class, 'admineliminar'])->name('admineliminar');

// CHAT
Route::get('/chatG', function () {
    return view('vistas.chat');
});

// Info de los registros
Route::get('/contactanos', function () {
    return view('vistas.contactanos');
})->name('contactanos');

/* Gestión empleados prueba Iker */
Route::get('/gestEmpleados', [EmpleadosController::class, 'index'])->name('gestEmpleados'); // Mostrar todos los empleados
Route::post('/empleado/store', [EmpleadosController::class, 'store'])->name('empleado.store'); // Registrar
Route::get('/empleado/{id}/edit', [EmpleadosController::class, 'edit'])->name('empleado.edit'); // Editar un empleado
Route::put('/empleado/update/{id}', [EmpleadosController::class, 'update'])->name('empleado.update'); // Actualizar datos de un empleado
Route::delete('/empleado/destroy/{id}', [EmpleadosController::class, 'destroy'])->name('empleado.destroy'); // Eliminar un empleado
Route::get('/empleados/exportarCSV', [EmpleadosController::class, 'exportarCSV'])->name('empleados.exportarCSV');

/* Rutas para el historial */
Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
Route::post('/historial/buscar', [HistorialController::class, 'buscarHistorial'])->name('historial.buscar');
Route::get('/actualizar-tabla', 'HistorialController@actualizarTabla')->name('actualizar.tabla');
Route::get('/historial/exportarCSV', [HistorialController::class, 'exportarCSV'])->name('historial.exportarCSV');

// Ruta para la página de admin
Route::get('/mapa', [MapaGestorController::class, 'index'])->name('mapa');
Route::post('/parking', [MapaGestorController::class, 'store'])->name('parking.post');
Route::get('/parking/{id}', [MapaGestorController::class, 'show'])->name('parking.show');
Route::put('/parking/{id}', [MapaGestorController::class, 'update'])->name('parking.update');
Route::delete('/parking/{id}', [MapaGestorController::class, 'destroy'])->name('parking.destroy');
Route::get('/exportar-csv', [MapaGestorController::class, 'exportarCSV'])->name('exportarCSV');
Route::put('/parking/{id}/update-location', [MapaGestorController::class, 'updateLocation']);
Route::post('/parking/update/{id}', [MapaGestorController::class, 'updateLocation']);
Route::get('/plazasParking', [MapaGestorController::class, 'showPlazas']);


/////// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// Rutas ubicaciones
Route::get('/ubicaciones', [UbicacionesController::class, 'index'])->name('ubicaciones');
Route::post('/ubicaciones/store', [UbicacionesController::class, 'store'])->name('ubicaciones.store');
Route::put('/ubicaciones/{id}', [UbicacionesController::class, 'update'])->name('ubicaciones.update');
Route::delete('/ubicaciones/{id}', [UbicacionesController::class, 'destroy'])->name('ubicaciones.destroy');
Route::get('/ubicaciones/{id}/edit', [UbicacionesController::class, 'edit'])->name('ubicaciones.edit');
Route::get('/ubicaciones/exportar-csv', [UbicacionesController::class, 'exportarCSV'])->name('ubicaciones.exportar.csv');

Route::get('/reservas', function () {
    return view('gestion.reservas');
})->name('reservas');
