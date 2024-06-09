<?php

namespace App\Http\Controllers;

use App\Models\tbl_registros;
use App\Models\tbl_reservas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class espiaController extends Controller
{
    public function espia(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');
        $accion = $request->input('acciones');

        if ($accion == 'entrada' || $accion == 'salida') {
            $request->validate([
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'acciones' => 'required|string'
            ]);

            $latitudUsuario = $request->latitud;
            $longitudUsuario = $request->longitud;

            $registro = new tbl_registros();
            $registro->accion = ($accion == 'entrada') ? 'Llevar el coche al parkin' : 'Llevar el coche al cliente';
            $registro->tipo = ($accion == 'entrada') ? 'Ir al parkin' : 'Ir hacia el cliente';
            $registro->id_usuario = $request->session()->get('id');
            $registro->latitud = $latitudUsuario;
            $registro->longitud = $longitudUsuario;
            $registro->id_reserva = $request->session()->get('codigoReserva');
            $registro->id_empresa = $idEmpresa;
            $registro->fecha_creacion = now();
            $registro->save();

            return response()->json(['message' => 'Coordenadas guardadas correctamente'], 200);
        }

        return response()->json(['error' => 'Acción no válida'], 400);
    }

    public function espia2(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');
        $accion = $request->input('acciones');

        if ($accion == 'entrada' || $accion == 'salida') {
            $request->validate([
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'acciones' => 'required|string'
            ]);

            $latitudUsuario = $request->latitud;
            $longitudUsuario = $request->longitud;

            $registro = new tbl_registros();
            $registro->accion = ($accion == 'entrada') ? 'Llevar el coche al parkin' : 'Ir hacia el cliente';
            $registro->tipo = 'Aparcar coche';
            $registro->id_usuario = $request->session()->get('id');
            $registro->latitud = $latitudUsuario;
            $registro->longitud = $longitudUsuario;
            $registro->id_reserva = $request->session()->get('codigoReserva');
            $registro->id_empresa = $idEmpresa;
            $registro->fecha_creacion = now();
            $registro->save();

            return response()->json(['message' => 'Coordenadas guardadas correctamente'], 200);
        }

        return response()->json(['error' => 'Acción no válida'], 400);
    }

    public function notaR(Request $request)
    {
        $request->validate([
            'idR' => 'required|exists:tbl_reservas,id',
            'notas' => 'nullable|string',
        ]);

        try {
            $reserva = tbl_reservas::findOrFail($request->idR);
            $reserva->notas = $request->notas ?? ''; // Asigna una cadena vacía si 'notas' está vacío
            $reserva->save();

            return response()->json(['message' => 'Notas actualizadas correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar las notas de la reserva'], 500);
        }
    }
}
