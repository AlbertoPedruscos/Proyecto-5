<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\tbl_parking;
use App\Models\tbl_plazas;
use App\Models\tbl_registros;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ParkingController extends Controller
{
    public function updateLocation(Request $request, $id)
    {
        // Encuentra el parking por ID
        $parking = tbl_parking::find($id);

        // Verifica si el parking existe
        if (!$parking) {
            return Response::json([
                'success' => false,
                'message' => 'Parking no encontrado.',
            ], 404);
        }

        // Valida los datos de entrada
        $validated = $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        // Actualiza las coordenadas del parking
        $parking->latitud = $validated['latitud'];
        $parking->longitud = $validated['longitud'];

        try {
            // Guarda los cambios en la base de datos
            $parking->save();

            return Response::json([
                'success' => true,
                'message' => 'Ubicación actualizada con éxito.',
            ]);
        } 
        
        catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error al guardar los cambios.',
            ], 500);
        }
    }

    public function showPlazas(Request $request)
    {
        $parkingId = $request->query('parking');
    
        // Obtener el parking por su ID
        $parking = tbl_parking::find($parkingId);
    
        if (!$parking) {
            // Si no se encuentra el parking, redirigir a una página de error o gestionar como sea necesario
            abort(404);
        }

        $idEmpresa = $request->session()->get('empresa');

        // Almacenar el ID del parking en la sesión
        Session::put('id_parking', $parkingId);
    
        // Obtener las plazas de parking para el parking específico
        $plazas = tbl_plazas::where('id_parking', $parkingId)->get();
    
        // Almacenar las plazas en la sesión
        Session::put('plazas', $plazas);
    
        // Pasar los datos del parking y las plazas a la vista
        return view('/gestion.plazasParking', compact('parking', 'plazas'));
    }
}
