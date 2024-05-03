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

    public function store(Request $request) 
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'empresa' => 'required|exists:tbl_empresas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'latitud.required' => 'La latitud es obligatoria.',
            'longitud.required' => 'La longitud es obligatoria.',
            'empresa.required' => 'La empresa es obligatoria.',
        ]);

        // Crear una instancia de usuario
        $parking = new tbl_parking();
        $parking->nombre = $request->nombre;
        $parking->latitud = $request->latitud;
        $parking->longitud = $request->longitud;
        $parking->id_empresa =  $request->empresa;

        // Verificar si el usuario ya existe
        $parkingExists = tbl_parking::where('nombre', $request->nombre)->exists();
        if ($parkingExists) {
            return redirect()->back()->withInput()->withErrors(['email' => 'El nombre del parking ya está registrado.']);
        }
        
        // Guardar el usuario
        $parking->save();

        return redirect()->route('mapa_admin')->with('success', 'Parking registrado exitosamente.');
    }

    public function destroy($id)
    {
        try {
            // Buscar y eliminar el parking por su ID
            $parking = tbl_parking::findOrFail($id);
            $parking->delete();
            return redirect()->route('mapa_admin')->with('success', 'Parking eliminado exitosamente.');
        } 
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el parking: ' . $e->getMessage()
            ], 500);
        }
    }
}
