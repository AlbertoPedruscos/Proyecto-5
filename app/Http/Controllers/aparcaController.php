<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modeloPlazas; // Importar el modelo TblParking
use App\Models\modeloReserva; // Importar el modelo TblParking

class AparcaController extends Controller
{
    // Función para realizar una consulta de conteo de aparcamientos
    public function aparca()
    {
        // Realizar la consulta de conteo utilizando el modelo TblParking
        $plazas = modeloPlazas::all(); // Obtener todas las plazas

        // Crear un array para almacenar la información de cada plaza
        $plazasData = [];

        foreach ($plazas as $plaza) {
            // Obtener la ID, el nombre y el estado de cada plaza
            $plazaData = [
                'id' => $plaza->id, // Obtener la ID de la plaza
                'nombre' => $plaza->nombre,
                'id_estado' => $plaza->id_estado,
            ];

            // Agregar la información de la plaza al array de plazas
            $plazasData[] = $plazaData;
        }

        // Crear un array que contenga el conteo y la información de las plazas
        $data = [
            'count' => count($plazasData), // Obtener el conteo de plazas
            'plazas' => $plazasData, // Almacenar la información de las plazas
        ];

        // Convertir el array a formato JSON y retornarlo
        return response()->json($data);
    }
    public function reserva(Request $request)
    {
        // Validamos los datos recibidos del formulario
        $request->validate([
            'id_plaza' => 'required|exists:tbl_plazas,id',
            'nom_cliente' => 'required|exists:tbl_reservas,id|max:45',
            'firma_imagen' => 'required|image', // Aseguramos que se haya enviado una imagen
        ]);     

        // Guardamos la imagen de la firma en la carpeta public/img/firmas
        try {
            $firmaImagen = $request->file('firma_imagen');
            $firmaPath = $firmaImagen->store('img/firmas', 'public');
        } catch (\Exception $e) {
            // Error al guardar la imagen
            return response()->json(['error' => 'Error al guardar la imagen: ' . $e->getMessage()], 500);
        }

        $modelo = modeloPlazas::find($request->id_plaza);
        $modelo->update(['id_estado' => 1]);

        $idtrabajador = session('id');
        // Creamos una nueva instancia de TblReserva con los datos del formulario
        $reserva = modeloReserva::where('id', $request->nom_cliente)->first();
        $reserva->id_trabajador = $idtrabajador;
        $reserva->firma = $firmaPath;
        $reserva->save();
        
        // Guardamos la reserva en la base de datos
        try {
            $reserva->save();
        } catch (\Exception $e) {
            // Error al guardar la reserva en la base de datos
            // Puedes manejar este error según tus necesidades, por ejemplo, eliminando la imagen guardada anteriormente
            return response()->json(['error' => 'Error al guardar la reserva: ' . $e->getMessage()], 500);
        }

        // Retornamos una respuesta adecuada, por ejemplo, un mensaje de éxito
        return response()->json(['message' => 'Reserva realizada correctamente'], 200);
    }

}
