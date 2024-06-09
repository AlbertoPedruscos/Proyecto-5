<?php

namespace App\Http\Controllers;

use App\Models\tbl_ubicaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class hacerUbis extends Controller
{
    public function eliminarUbica(Request $request) {
        // Validar la solicitud
        $validated = $request->validate([
            'id' => 'required|integer|exists:tbl_ubicaciones,id',
        ]);
    
        // Obtener el ID de la subincidencia
        $id = $request->input('id');
    
        try {
            // Buscar y eliminar la subincidencia
            $subincidencia = tbl_ubicaciones::findOrFail($id);
            $subincidencia->delete();
    
            // Responder con éxito
            return response()->json(['message' => 'Subincidencia eliminada exitosamente.'], 200);
        } catch (\Exception $e) {
            // Manejar errores
            return response()->json(['message' => 'Hubo un error al eliminar la subincidencia.'], 500);
        }
    }
    public function editarUbicacion(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'id' => 'required|exists:tbl_ubicaciones,id',
            'nombre_sitio' => 'required',
            'calle' => 'required',
            'ciudad' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        try {
            // Obtener la ubicación a editar
            $ubicacion = tbl_ubicaciones::findOrFail($request->id);

            // Actualizar los datos de la ubicación
            $ubicacion->nombre_sitio = $request->nombre_sitio;
            $ubicacion->calle = $request->calle;
            $ubicacion->ciudad = $request->ciudad;
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();

            // Respuesta exitosa
            return response()->json(['message' => 'Ubicación actualizada correctamente'], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => 'Error al actualizar la ubicación'], 500);
        }
    }
    public function buscarUbicaciones(Request $request)
    {
        $html='';
        // Obtener el término de búsqueda del formulario
        $termino_busqueda = $request->lupa;

        $ubicaciones = tbl_ubicaciones::where('empresa', session('empresa'))
        ->where(function ($query) use ($termino_busqueda) {
            $query->where('nombre_sitio', 'LIKE', '%' . $termino_busqueda . '%')
                ->orWhere('calle', 'LIKE', '%' . $termino_busqueda . '%')
                ->orWhere('ciudad', 'LIKE', '%' . $termino_busqueda . '%');
        })
        ->get();    

        // Generar la tabla HTML
        $html .= '<tbody>';
        foreach ($ubicaciones as $ubicacion) {
            $html .= '<tr>';
            $html .= '<td>' . $ubicacion->nombre_sitio . '</td>';
            $html .= '<td>' . $ubicacion->calle . '</td>';
            $html .= '<td>' . $ubicacion->ciudad . '</td>';
            $html .= '<td>' . $ubicacion->latitud . '</td>';
            $html .= '<td>' . $ubicacion->longitud . '</td>';
            $html .= '<td><button class="btn btn-primary" onclick="editar(\'' . $ubicacion->id . '\', \'' . $ubicacion->empresa . '\', \'' . $ubicacion->nombre_sitio . '\', \'' . $ubicacion->calle . '\', \'' . $ubicacion->ciudad . '\', \'' . $ubicacion->latitud . '\', \'' . $ubicacion->longitud . '\')">Editar</button></td>';
            $html .= '<td><button class="btn btn-danger" onclick="eliminar(' . $ubicacion->id . ')">Eliminar</button></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';        
        // $html='hola';

        // Imprimir la tabla en HTML
        echo $html;
    }
    public function masUbi(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_sitio' => 'required',
            'calle' => 'required',
            'ciudad' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        try {
            // Crear una nueva instancia del modelo tbl_ubicaciones
            $ubicacion = new tbl_ubicaciones();
            // Asignar los valores recibidos del formulario a los atributos del modelo
            $ubicacion->empresa = session('empresa');
            $ubicacion->nombre_sitio = $request->nombre_sitio;
            $ubicacion->calle = $request->calle;
            $ubicacion->ciudad = $request->ciudad;
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            // Guardar el registro en la base de datos
            $ubicacion->save();

            // Redireccionar a alguna vista o responder con un mensaje de éxito
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return redirect()->route('ubicaciones.index')->with('error', 'Error al crear la ubicación: ' . $e->getMessage());
        }
    }
}
