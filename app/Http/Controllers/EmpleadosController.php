<?php

namespace App\Http\Controllers;

use App\Models\tbl_usuarios;
use App\Models\tbl_empresas;
use App\Models\tbl_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmpleadosController extends Controller
{
    public function index(Request $request) {
        $idEmpresa = $request->session()->get('empresa');
        $perPage = $request->query('perPage', 10); // Establece el valor predeterminado a 10
        $search = $request->query('search', '');
        $rol = $request->query('rol', '');
    
        // Filtrar empleados según la búsqueda y el rol
        $query = tbl_usuarios::where('id_empresa', $idEmpresa);
    
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', '%'.$search.'%')
                  ->orWhere('apellidos', 'like', '%'.$search.'%');
            });
        }
    
        if (!empty($rol)) {
            $query->where('id_rol', $rol);
        }
    
        // Contar el total de empleados
        $totalEmpleados = $query->count();
    
        // Obtener empleados con paginación
        $empleados = $query->paginate($perPage);
    
        $roles = tbl_roles::all();
    
        // Verifica si perPage tiene un valor y lo establece como seleccionado en el select
        $perPageOptions = [5, 10, 25, 50];
        if (in_array($perPage, $perPageOptions)) {
            return view('gestion.gestEmpleados', compact('empleados', 'roles', 'totalEmpleados', 'perPage', 'search', 'rol'));
        } else {
            // Si perPage no tiene un valor válido, redirige con perPage predeterminado
            return redirect()->route('gestEmpleados', ['perPage' => 5]);
        }
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
        ]);
    
        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellidos');
        $empleado->save();
    
        return redirect()->route('gestEmpleados')->with('success', 'Empleado actualizado correctamente.');
    }
    
    public function store(Request $request) {
        $idEmpresa = $request->session()->get('empresa');
        $nombreEmpresa = tbl_empresas::find($idEmpresa)->nombre; // Reemplaza 'Empresa' con el modelo real de tu empresa
    
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
        ]);
    
        $nombreEmpresaSinEspacios = str_replace(' ', '', $nombreEmpresa);
    
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellido');
    
        // Eliminar espacios adicionales en nombre y apellidos
        $nombreSinEspacios = str_replace(' ', '', $nombre);
        $apellidosSinEspacios = str_replace(' ', '', $apellidos);
    
        // Formar el email usando el nombre y apellidos sin espacios
        $email = strtolower($nombreSinEspacios . '.' . $apellidosSinEspacios . '@' . $nombreEmpresaSinEspacios . '.com');
    
        $empleado = new tbl_usuarios();
        $empleado->nombre = $nombre;
        $empleado->apellidos = $apellidos;
        $empleado->email = $email; // Usar el email formado
        $empleado->contrasena = bcrypt('qweQWE123');
        $empleado->id_rol = 3;
        $empleado->id_empresa = $idEmpresa;
        $empleado->save();
    
        return redirect()->route('gestEmpleados')->with('success', 'Usuario registrado correctamente.');
    }    
    public function destroy($id) {
        $empleado = tbl_usuarios::findOrFail($id);
        if ($empleado->id_rol == 2) { // Usar operador de comparación (==) en lugar de asignación (=)
            return redirect()->route('gestEmpleados')->with('error', 'No puedes eliminar al gestor.');
        } else {
            $empleado->delete();
            return redirect()->route('gestEmpleados')->with('success', 'Usuario eliminado correctamente.');
        }
    }

    public function buscarEmpleado(Request $request) {
        $query = tbl_usuarios::where('id_empresa', $request->session()->get('empresa'));

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%'.$request->search.'%')
                  ->orWhere('apellidos', 'like', '%'.$request->search.'%'); // Ajuste para buscar también por apellidos
            });
        }

        if ($request->filled('rol')) {
            $query->where('id_rol', $request->rol);
        }

        $empleados = $query->get();

        return Response::json(view('tablas.tbl_empleados', compact('empleados'))->render());
    }
}
