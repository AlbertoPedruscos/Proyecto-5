<?php

namespace App\Http\Controllers;

use App\Models\tbl_reservas;
use Illuminate\Http\Request;

class DatoController extends Controller
{
    public function index()
    {
        // Obtener todos los datos desde la base de datos
        $datos = tbl_reservas::all();
        return response()->json($datos);
    }
}
