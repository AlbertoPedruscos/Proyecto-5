<?php

namespace App\Http\Controllers;
use App\Models\modeloRegistros;
use App\Models\parkines;
use Illuminate\Http\Request;

class espiaController extends Controller
{
    public function espia(Request $request)
    {
        // Validar los datos del formulario (si es necesario)
        $request->validate([
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        // Obtener las coordenadas del usuario del formulario
        $latitudUsuario = $request->latitud;
        $longitudUsuario = $request->longitud;

        // Obtener las coordenadas del estacionamiento con id igual a 1
        $estacionamiento = parkines::find(1);
        $latitudEstacionamiento = $estacionamiento->latitud;
        $longitudEstacionamiento = $estacionamiento->longitud;

        // Calcular la distancia entre las coordenadas del usuario y las del estacionamiento
        $distancia = $this->calcularDistancia($latitudUsuario, $longitudUsuario, $latitudEstacionamiento, $longitudEstacionamiento);

        // Si la distancia es menor o igual a 500 metros, detener el intervalo
        if ($distancia <= 500) {
            // Aquí puedes realizar alguna acción adicional si lo necesitas
            // Por ejemplo, guardar las coordenadas en la base de datos
            $coordenada = new modeloRegistros();
            $coordenada->id_usuario = 1; // Suponiendo que el ID de usuario es 1
            $coordenada->latitud = $latitudUsuario;
            $coordenada->longitud = $longitudUsuario;
            $coordenada->save();

            return response()->json(['message' => 'Coordenadas guardadas correctamente'], 200);
        } else {
            return response()->json(['message' => 'Usuario fuera del área de 500 metros'], 400);
        }
    }

    // Función para calcular la distancia entre dos puntos (coordenadas)
    private function calcularDistancia($latitud1, $longitud1, $latitud2, $longitud2)
    {
        $radioTierra = 6371000; // Radio de la Tierra en metros
        $deltaLatitud = deg2rad($latitud2 - $latitud1);
        $deltaLongitud = deg2rad($longitud2 - $longitud1);
        $a = sin($deltaLatitud / 2) * sin($deltaLatitud / 2) + cos(deg2rad($latitud1)) * cos(deg2rad($latitud2)) * sin($deltaLongitud / 2) * sin($deltaLongitud / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distancia = $radioTierra * $c;
        return $distancia;
    }
}
