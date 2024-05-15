<?php

namespace App\Http\Controllers;

use App\Models\tbl_usuarios;
use App\Models\tbl_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmpleadosController extends Controller
{
    public function index(Request $request) {
        $empleados = tbl_usuarios::where('id_rol', '=', 3)->where('id_empresa', '=', $request->session()->get('empresa'))->get();
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
        $query = tbl_usuarios::query();
    
        // Filtrar por nombre si se proporciona
        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }
    
        // Filtrar por rol si se selecciona
        if ($request->has('rol')) {
            $query->where('id_rol', $request->rol);
        }
    
        $empleados = $query->get();
    
        return Response::json(view('tablas.tbl_empleados', compact('empleados'))->render());
    }
}
