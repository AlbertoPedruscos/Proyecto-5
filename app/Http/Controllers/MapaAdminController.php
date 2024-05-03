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

    public function destroy($id)
    {
        try {
            // Encuentra el parking por ID y elimínalo
            $parking = Parking::findOrFail($id);
            $parking->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Parking eliminado con éxito.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el parking.'
            ], 500);
        }
    }
}
