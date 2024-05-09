<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modeloReserva;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservasController extends Controller
{
    public function mostrarR(Request $request) {
        // Obtener el filtro enviado desde la solicitud Ajax
        $filtro = "%" . $request->input('filtro') . "%";
        $fechaActual = Carbon::now()->toDateTimeString();
    
        // Filtrar las reservas según el filtro
        $fechaHoy = date('Y-m-d');
        $fechaHoyInicio = $fechaHoy . ' 00:00:00';
        $fechaHoyFin = $fechaHoy . ' 23:59:59';

        $reservas = modeloReserva::with('trabajador')
            ->selectRaw('*, DATE_FORMAT(fecha_entrada, "%H:%i") as hora_entrada, DATE_FORMAT(fecha_salida, "%H:%i") as hora_salida')
            ->where(function($query) use ($filtro) {
                $query->where('tbl_reservas.id', 'LIKE', $filtro)
                    ->orWhere('nom_cliente', 'LIKE', $filtro)
                    ->orWhere('matricula', 'LIKE', $filtro)
                    ->orWhere('num_telf', 'LIKE', $filtro)
                    ->orWhere('tbl_reservas.email', 'LIKE', $filtro);
            });

        // Verificar si el filtro está vacío para aplicar el filtro por fecha
        if (empty($request->input('filtro'))) {
            $reservas->where(function($query) use ($fechaHoyInicio, $fechaHoyFin) {
                $query->whereBetween('fecha_entrada', [$fechaHoyInicio, $fechaHoyFin])
                      ->orWhereBetween('fecha_salida', [$fechaHoyInicio, $fechaHoyFin]);
            });
        }

        $reservas = $reservas->orderBy('fecha_entrada', 'asc')
            ->get();
    
        // Devolver la vista con las reservas filtradas
        return response()->json(['reservas' => $reservas]);
    
    }
    public function info(Request $request) {
        $id_res = $request->input('id');
    }
}
