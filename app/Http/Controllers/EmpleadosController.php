<?php

namespace App\Http\Controllers;

use App\Models\tbl_usuarios;
use App\Models\tbl_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmpleadosController extends Controller
{
    public function index(Request $request) {
        $idEmpresa = $request->session()->get('empresa');
        $empleados = tbl_usuarios::where('id_empresa', $idEmpresa)->get();
        $roles = tbl_roles::all();
        return view('gestion.gestEmpleados', compact('empleados','roles'));
    }
    
    public function store(Request $request) {
        $idEmpresa = $request->session()->get('empresa');

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_usuarios',
            'pass' => 'required|string|min:6|max:20', 
        ]);
    
        $empleado = new tbl_usuarios();
        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellido');
        $empleado->email = $request->input('email');
        $empleado->contrasena = bcrypt($request->input('pass'));
        $empleado->id_rol = 3;
        $empleado->id_empresa = $idEmpresa;
        $empleado->save();
    
        return redirect()->back()->with('success', 'Usuario registrado correctamente.');
    }
        
    public function show($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }

    public function buscarEmpleado(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');
        $query = tbl_usuarios::where('id_empresa', $idEmpresa);
    
        // Filtrar por nombre si se proporciona
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }
    
        // Filtrar por rol si se selecciona
        if ($request->filled('rol')) {
            $query->where('id_rol', $request->rol);
        }
    
        // Si no se proporciona ningún filtro, devolver todos los empleados
        if (!$request->filled('search') && !$request->filled('rol')) {
            $query->where('id_empresa', $idEmpresa);
        }
    
        // Obtener los empleados según la consulta
        $empleados = $query->get();
    
        // Renderizar la vista de la tabla de empleados con los datos obtenidos
        $view = view('tablas.tbl_empleados', compact('empleados'))->render();
    
        // Devolver la respuesta como JSON
        return response()->json($view);
    }
}
