<?php

namespace App\Http\Controllers;

use App\Models\tbl_usuarios;
use App\Models\tbl_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class EmpleadosController extends Controller
{
    public function index(Request $request) {
        $idEmpresa = $request->session()->get('empresa');
        $perPage = $request->query('perPage', 5); 
        $empleados = tbl_usuarios::where('id_empresa', $idEmpresa)->paginate($perPage);
        $roles = tbl_roles::all();
        $totalEmpleados = tbl_usuarios::where('id_empresa', $idEmpresa)->count();
        return view('gestion.gestEmpleados', compact('empleados', 'roles', 'totalEmpleados'));
        
    }
            
    public function edit($id) {
        $empleado = tbl_usuarios::findOrFail($id);
        return response()->json($empleado);
    }
    
    public function update(Request $request, $id) {
        $empleado = tbl_usuarios::findOrFail($id);
    
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_usuarios,email,'.$empleado->id,
        ]);
    
        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellidos');
        $empleado->email = $request->input('email');
        $empleado->save();
    
        return redirect()->route('gestEmpleados')->with('success', 'Empleado actualizado correctamente.');
    }

    public function store(Request $request) {
        $idEmpresa = $request->session()->get('empresa');
    
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_usuarios',
        ]);
    
        $empleado = new tbl_usuarios();
        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellido');
        $empleado->email = $request->input('email');
        $empleado->contrasena = bcrypt('qweQWE123');
        $empleado->id_rol = 3;
        $empleado->id_empresa = $idEmpresa;
        $empleado->save();
    
        return redirect()->route('gestEmpleados')->with('success', 'Usuario registrado correctamente.');
    }
        
    public function destroy($id)
    {
        $empleado = tbl_usuarios::findOrFail($id);
        if($empleado->id_rol == 2) { // Corregir el operador de comparación
            return redirect()->route('gestEmpleados')->with('error', 'No puedes eliminar al gestor.');
        }
        else {
            $empleado->delete();
            return redirect()->route('gestEmpleados')->with('success', 'Usuario eliminado correctamente.');
        }
    }
            
    // public function buscarEmpleado(Request $request)
    // {
    //     $idEmpresa = $request->session()->get('empresa');
    
    //     \Log::info('Buscar Empleado - Empresa ID:', ['idEmpresa' => $idEmpresa]);
    //     \Log::info('Buscar Empleado - Request Data:', ['search' => $request->search, 'rol' => $request->rol]);
    
    //     $query = tbl_usuarios::where('id_empresa', $idEmpresa);
    
    //     if ($request->filled('search')) {
    //         \Log::info('Buscar Empleado - Filtrar por Nombre:', ['search' => $request->search]);
    //         $query->where('nombre', 'like', '%' . $request->search . '%');
    //     }
    
    //     if ($request->filled('rol')) {
    //         \Log::info('Buscar Empleado - Filtrar por Rol:', ['rol' => $request->rol]);
    //         $query->where('id_rol', $request->rol);
    //     }
    
    //     try {
    //         $empleados = $query->get();
    //         \Log::info('Buscar Empleado - Empleados Encontrados:', ['empleados' => $empleados]);
    
    //         $view = view('tablas.tbl_empleados', compact('empleados'))->render();
    //         return response()->json($view);
    //     } catch (\Exception $e) {
    //         \Log::error('Error al buscar empleados: ' . $e->getMessage(), ['exception' => $e]);
    //         return response()->json(['error' => 'Error al realizar la búsqueda.'], 500);
    //     }
    // }

    public function buscarEmpleado(Request $request)
    {
        $query = tbl_usuarios::where('id_empresa', $request->session()->get('empresa'));
    
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%'.$request->search.'%');
        }
    
        if ($request->filled('rol')) {
            $query->where('id_rol', $request->rol);
        }
    
        $empleados = $query->get();
    
        return Response::json(view('tablas.tbl_empleados', compact('empleados'))->render());
    }
}    