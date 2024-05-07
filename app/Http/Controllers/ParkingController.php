<?php

namespace App\Http\Controllers;
use App\Models\tbl_parking;

use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function updateLocation(Request $request, $id)
    {
        $parking = tbl_parking::find($id);
        if ($parking) {
            $parking->latitud = $request->input('latitud');
            $parking->longitud = $request->input('longitud');
            $parking->save(); // Guardar los cambios
            return redirect()->route('mapa_admin')->with('success', 'Ubicación cambiada correctamente.');
        } 
        
        else {
            return response()->json(['status' => 'error'], 404);
        }
    }
}
