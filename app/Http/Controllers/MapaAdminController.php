<?php

namespace App\Http\Controllers;

use App\Models\tbl_plazas;
use App\Models\tbl_parking;
use App\Models\tbl_estados;
use App\Models\tbl_empresas;

use Illuminate\Http\Request;

class MapaAdminController extends Controller
{
    /* Función para mostrar los parkings en el mapa */
    public function index()
    {
        $parkings = tbl_parking::with(['plazas', 'empresa'])->get();
        $plazas = tbl_plazas::all();
        $estados = tbl_estados::all();
        $empresas = tbl_empresas::all();

        return view('vistas.mapa_admin', compact('parkings', 'plazas', 'estados', 'empresas'));
    }
}
