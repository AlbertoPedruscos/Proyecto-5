<?php

namespace App\Http\Controllers;

use App\Models\tbl_ubicaciones;
use App\Models\tbl_empresas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UbicacionesController extends Controller
{
    public function index(Request $request)
    {
        $idEmpresa = session('empresa');
        $perPage = $request->get('perPage', 5);
        $page = $request->get('page', 1);
        $orderDirection = $request->get('orderDirection', 'desc'); // Orden por defecto: descendente

        $query = tbl_ubicaciones::where('empresa', $idEmpresa);

        if ($request->has('nombre_sitio')) {
            $query->where('nombre_sitio', $request->get('nombre_sitio'));
        }

        if ($request->has('ciudad')) {
            $query->where('ciudad', $request->get('ciudad'));
        }

        $ubicaciones = $query->orderBy('created_at', $orderDirection)->paginate($perPage, ['*'], 'page', $page);
        $totalUbicaciones = $query->count();

        return view('gestion.ubicaciones', compact('ubicaciones', 'totalUbicaciones', 'orderDirection'));
    }

    public function store(Request $request)
    {
        $idEmpresa = session('empresa');

        $request->validate([
            'nombre_sitio' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        tbl_ubicaciones::create([
            'empresa' => $idEmpresa,
            'nombre_sitio' => $request->nombre_sitio,
            'calle' => $request->calle,
            'ciudad' => $request->ciudad,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'created_at' => Carbon::now(), // Fecha de creación actual
            'updated_at' => Carbon::now(), // Fecha de actualización actual
        ]);

        return redirect()->route('ubicaciones')->with('success', 'Ubicación creada exitosamente.');
    }

    public function edit($id)
    {
        $ubicacion = tbl_ubicaciones::findOrFail($id);
        return response()->json($ubicacion);
    }

    public function update(Request $request, $id)
    {
        $ubicacion = tbl_ubicaciones::findOrFail($id);
        $ubicacion->update($request->only(['nombre_sitio', 'ciudad', 'calle', 'latitud', 'longitud']));
        return redirect()->back()->with('success', 'Ubicación actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $ubicacion = tbl_ubicaciones::findOrFail($id);
        $ubicacion->delete();
        return redirect()->back()->with('success', 'Ubicación eliminada exitosamente.');
    }

    public function exportarCSV(Request $request)
    {
        $idEmpresa = session('empresa');
        $nombreEmpresa = tbl_empresas::where('id', $idEmpresa)->value('nombre'); // Obtener el nombre de la empresa
    
        // Reemplazar espacios en el nombre de la empresa con guiones bajos
        $nombreEmpresaSinEspacios = str_replace(' ', '_', $nombreEmpresa);
    
        // Obtener todas las ubicaciones de la empresa
        $ubicaciones = tbl_ubicaciones::where('empresa', $idEmpresa)->get();
    
        // Fecha y hora actual formateada
        $fechaHora = now()->format('Ymd_His');
    
        // Nombre del archivo CSV
        $nombreArchivo = "{$nombreEmpresaSinEspacios}_ubicaciones_{$fechaHora}.csv";
    
        // Encabezados del archivo CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$nombreArchivo\"",
        ];
    
        // Crear un objeto de flujo para escribir en el archivo CSV
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Nombre del Sitio', 'Calle', 'Ciudad', 'Latitud', 'Longitud']);
    
        // Escribir cada ubicación en el archivo CSV
        foreach ($ubicaciones as $ubicacion) {
            fputcsv($output, [
                $ubicacion->nombre_sitio,
                $ubicacion->calle,
                $ubicacion->ciudad,
                $ubicacion->latitud,
                $ubicacion->longitud,
            ]);
        }
    
        // Cerrar el flujo de escritura
        fclose($output);
    
        // Devolver el archivo CSV como una descarga
        return response()->stream(function () use ($output) {
            //
        }, 200, $headers);
    }
}
