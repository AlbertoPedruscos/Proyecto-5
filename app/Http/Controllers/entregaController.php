<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; // Importar la clase Str para generar UUID
use App\Models\modeloReserva;

class entregaController extends Controller
{
    public function confirmarEntrega(Request $request)
    {
        // Validar y guardar la foto en el servidor
        if ($request->hasFile('firma')) {
            $foto = $request->file('firma');
            $nombreFoto = Str::uuid()->toString() . '.' . $foto->getClientOriginalExtension(); // Generar un UUID único y agregar la extensión original
            $ruta = $foto->storeAs('public/img/firmas', $nombreFoto); // Guardar la foto con el nombre único
            // Actualizar el nombre de la foto en la base de datos
            modeloReserva::where('id', '2141561966191692')->update([
                'firma_salida' => $nombreFoto // Guardar el nombre único en la base de datos
            ]);
            return response()->json(['message' => 'Foto actualizada']);
        } else {
            return response()->json(['error' => 'No se recibió ninguna foto'], 400);
        }
    }
}


