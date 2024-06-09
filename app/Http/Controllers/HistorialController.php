<?php
// app/Http/Controllers/HistorialController.php

namespace App\Http\Controllers;

use App\Models\tbl_empresas;
use App\Models\tbl_usuarios;
use App\Models\tbl_registros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');

        $usuarios = tbl_usuarios::where('id_empresa', $idEmpresa)->where('id_rol', 3)->get();

        $usuarioId = $request->input('usuario');
        $orden = $request->input('orden');
        $usuarioNombre = $request->input('usuario_nombre');
        $perPage = $request->input('perPage', 10);

        $query = tbl_registros::where('tbl_registros.id_empresa', $idEmpresa)
                    ->join('tbl_usuarios', 'tbl_registros.id_usuario', '=', 'tbl_usuarios.id')
                    ->select('tbl_registros.*', 'tbl_usuarios.nombre as usuario_nombre');

        if ($usuarioId) {
            $query->where('tbl_registros.id_usuario', $usuarioId);
        }

        if ($usuarioNombre) {
            $query->where('tbl_usuarios.nombre', 'like', '%' . $usuarioNombre . '%');
        }

        if ($orden === 'antiguas') {
            $query->orderBy('tbl_registros.fecha_creacion', 'asc');
        } elseif ($orden === 'recientes') {
            $query->orderBy('tbl_registros.fecha_creacion', 'desc');
        }

        $historial = $query->paginate($perPage);

        return view('gestion.historial', compact('historial', 'usuarios', 'usuarioNombre', 'orden', 'perPage'));
    }

    public function exportarCSV(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');
        $usuarioId = $request->input('usuario');
        $usuarioNombre = $request->input('usuario_nombre');
        $orden = $request->input('orden');
    
        $query = tbl_registros::where('tbl_registros.id_empresa', $idEmpresa)
                    ->join('tbl_usuarios', 'tbl_registros.id_usuario', '=', 'tbl_usuarios.id')
                    ->join('tbl_empresas', 'tbl_usuarios.id_empresa', '=', 'tbl_empresas.id')
                    ->select('tbl_registros.*', 'tbl_usuarios.nombre as usuario_nombre', 'tbl_empresas.nombre as nombre_empresa');
    
        if ($usuarioId) {
            $query->where('tbl_registros.id_usuario', $usuarioId);
        }
    
        if ($usuarioNombre) {
            $query->where('tbl_usuarios.nombre', 'like', '%' . $usuarioNombre . '%');
        }
    
        if ($orden === 'antiguas') {
            $query->orderBy('tbl_registros.fecha_creacion', 'asc');
        } elseif ($orden === 'recientes') {
            $query->orderBy('tbl_registros.fecha_creacion', 'desc');
        }
    
        $registros = $query->get();
    
        if ($registros->isEmpty()) {
            // Manejar el caso cuando no se encuentran registros
            // Por ejemplo, puedes redirigir o mostrar un mensaje de error
            return redirect()->back()->with('error', 'No se encontraron registros para exportar.');
        }
    
        // Generar el CSV
        $csvData = '';
        $empresa = str_replace(' ', '_', $registros->first()->nombre_empresa); // Reemplazar espacios en el nombre de la empresa
        $fileName = 'historial_' . $empresa . '_' . date('Ymd_His') . '.csv';
    
        // Define los encabezados del CSV
        $csvData .= "ID,Usuario,Empresa,Fecha,Hora,Otros Campos\n";
    
        // Loop a través de los registros y agrega sus datos al CSV
        foreach ($registros as $registro) {
            $fecha = date('Y-m-d', strtotime($registro->fecha_creacion));
            $hora = date('H:i:s', strtotime($registro->fecha_creacion));
            $csvData .= "{$registro->id},{$registro->usuario_nombre},{$registro->nombre_empresa},{$fecha},{$hora},Otros Valores\n";
        }
    
        // Establece los encabezados para descargar el archivo
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
    
        // Devuelve el CSV como una respuesta
        return response()->make($csvData, 200, $headers);
    }
}
