<?php

namespace App\Http\Controllers;

use App\Models\tbl_usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmpleadosController extends Controller
{
    public function index(Request $request) {
        $empleados = tbl_usuarios::all();
        return view('gestion.gestEmpleados', compact('empleados'));
    }
    
    public function store(Request $request) {
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
        $empleados = tbl_usuarios::where('nombre', 'like', '%'.$request->search.'%')->get();
        return Response::json(view('tablas.tbl_empleados', compact('empleados'))->render());
    }
}
