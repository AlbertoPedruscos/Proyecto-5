<?php

namespace App\Http\Controllers;

use App\Models\tbl_empresas;
use App\Models\tbl_roles;
use App\Models\tbl_usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmpleadosController extends Controller
{
    public function index(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');
    
        $nombre = $request->input('nombre');
        $rol = $request->input('rol');
        $perPage = $request->input('perPage', 5);
        $orderField = $request->input('orderField', 'id'); // Campo predeterminado para ordenar
        $orderDirection = $request->input('orderDirection', 'asc'); // Dirección predeterminada para ordenar
    
        // Usar la tabla de usuarios con un alias para mejorar la legibilidad
        $query = tbl_usuarios::where('id_empresa', $idEmpresa);
    
        if ($nombre) {
            $query->where(function ($q) use ($nombre) {
                $q->where('nombre', 'LIKE', '%' . $nombre . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $nombre . '%')
                    ->orWhereRaw("CONCAT(nombre, ' ', apellidos) LIKE ?", ['%' . $nombre . '%']);
            });
        }
    
        if ($rol) {
            $query->where('id_rol', $rol);
        }
    
        // Contar el total de empleados sin aplicar paginación ni filtros adicionales
        $totalEmpleados = tbl_usuarios::where('id_empresa', $idEmpresa)->count();
    
        // Aplicar ordenamiento utilizando un array asociativo
        $query->orderBy($orderField, $orderDirection);
    
        // Paginar los resultados
        $empleados = $query->paginate($perPage);
    
        // Obtener todos los empleados para el filtro de nombre
        $todosEmpleados = tbl_usuarios::where('id_empresa', $idEmpresa)->get();
    
        // Obtener todos los roles
        $roles = tbl_roles::all();
    
        if ($request->ajax()) {
            return view('tablas.tbl_empleados', compact('empleados'))->render();
        }
    
        // Pasar todas las variables necesarias a la vista, incluyendo el total de empleados sin aplicar filtros
        return view('gestion.gestEmpleados', compact('todosEmpleados', 'empleados', 'totalEmpleados', 'nombre', 'rol', 'roles', 'perPage', 'orderField', 'orderDirection'));
    }
    
    public function edit($id)
    {
        $empleado = tbl_usuarios::findOrFail($id);
        return response()->json([
            'id' => $empleado->id,
            'nombre' => $empleado->nombre,
            'apellidos' => $empleado->apellidos,
            'email' => $empleado->email,
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nombre' => 'required|string|max:255',
    //         'apellidos' => 'required|string|max:255',
    //     ]);

    //     $empleado = tbl_usuarios::findOrFail($id);
    //     $empleado->nombre = $request->input('nombre');
    //     $empleado->apellidos = $request->input('apellidos');

    //     // Actualizar el correo electrónico solo si ha cambiado el nombre o los apellidos
    //     $nuevoNombre = $request->input('nombre');
    //     $nuevosApellidos = $request->input('apellidos');
    //     $nuevoEmail = $this->generarEmail($nuevoNombre, $nuevosApellidos, $empleado->id_empresa);

    //     if ($nuevoEmail !== $empleado->email) {
    //         // Comprobar si el nuevo correo ya existe en otro empleado
    //         if (tbl_usuarios::where('email', $nuevoEmail)->where('id', '!=', $id)->exists()) {
    //             return redirect()->route('gestEmpleados')->with('error', 'El nuevo correo electrónico ya está en uso.');
    //         }

    //         // Actualizar el correo electrónico del empleado
    //         $empleado->email = $nuevoEmail;
    //     }

    //     // Guardar los cambios en el empleado
    //     $empleado->save();

    //     return redirect()->route('gestEmpleados')->with('success', 'Empleado actualizado correctamente.');
    // }

    public function update(Request $request, $id)
    {
        $empleado = tbl_usuarios::findOrFail($id);
    
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
        ]);

        $nombreAnterior = $empleado->nombre;
        $apellidosAnteriores = $empleado->apellidos;

        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellidos');
        $empleado->save();

        // Generar nuevo correo electrónico
        $nuevoNombre = $request->input('nombre');
        $nuevosApellidos = $request->input('apellidos');
        $nuevoEmail = $this->generarEmail($nuevoNombre, $nuevosApellidos, $empleado->id_empresa);

        // Actualizar el correo electrónico solo si ha cambiado el nombre o los apellidos
        if ($nuevoEmail !== $empleado->email) {
            $empleado->email = $nuevoEmail;
            $empleado->save();
        }
    
        return redirect()->route('gestEmpleados')->with('success', 'Empleado actualizado correctamente.');
    }
        
    public function store(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa');
        $nombreEmpresa = tbl_empresas::find($idEmpresa)->nombre;

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
        ]);

        $email = $this->generarEmail($request->input('nombre'), $request->input('apellido'), $idEmpresa);

        // Comprobar si el correo ya existe
        if (tbl_usuarios::where('email', $email)->exists()) {
            return redirect()->route('gestEmpleados')->with('error', 'El correo electrónico ya existe.');
        }

        $empleado = new tbl_usuarios();
        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellido');
        $empleado->email = $email;
        $empleado->contrasena = bcrypt('qweQWE123');
        $empleado->id_rol = 3;
        $empleado->id_empresa = $idEmpresa;
        $empleado->save();

        return redirect()->route('gestEmpleados')->with('success', 'Usuario registrado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = tbl_usuarios::findOrFail($id);
        if ($empleado->id_rol == 2) { // Usar operador de comparación (==) en lugar de asignación (=)
            return redirect()->route('gestEmpleados')->with('error', 'No puedes eliminar al gestor.');
        } else {
            $empleado->delete();
            return redirect()->route('gestEmpleados')->with('success', 'Usuario eliminado correctamente.');
        }
    }
    
    private function generarEmail($nombre, $apellidos, $idEmpresa)
    {
        $empresa = tbl_empresas::find($idEmpresa);
        $nombreLimpio = $this->cleanString($nombre);
        $apellidosLimpios = $this->cleanString($apellidos);
        $nombreEmpresaLimpio = $this->cleanString($empresa->nombre);
        return $nombreLimpio . '.' . $apellidosLimpios . '@' . $nombreEmpresaLimpio . '.com';
    }

    private function cleanString($string)
    {
        $search = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N'];
        $string = str_replace($search, $replace, $string);
        $string = strtolower($string);
        $string = str_replace(' ', '', $string);
        $string = preg_replace('/[^a-z0-9.]/', '', $string);
        return $string;
    }

    public function exportarCSV()
    {
        $idEmpresa = session()->get('empresa');
        $empleados = tbl_usuarios::where('id_empresa', $idEmpresa)->get();
        $csvData = '';
        
        // Obtener el nombre de la empresa sin espacios
        $nombreEmpresa = tbl_empresas::where('id', $idEmpresa)->value('nombre');
        $nombreEmpresaSinEspacios = str_replace(' ', '_', $nombreEmpresa);
        
        // Obtener la fecha y hora actual
        $fechaHora = now()->format('Ymd_His');
        
        // Define los encabezados del archivo CSV
        $csvData .= "Nombre,Apellidos,Email,Empresa,Fecha,Hora\n";
        
        // Recorre los empleados y agrega sus datos al contenido del CSV
        foreach ($empleados as $empleado) {
            $fecha = date('Y-m-d', strtotime($empleado->created_at));
            $hora = date('H:i:s', strtotime($empleado->created_at));
            // Verifica si la empresa está definida para el empleado
            $nombreEmpresa = isset($empleado->empresa->nombre) ? $empleado->empresa->nombre : 'Sin Empresa';
            $csvData .= "{$empleado->nombre},{$empleado->apellidos},{$empleado->email},{$nombreEmpresa},{$fecha},{$hora}\n";
        }
        
        // Define el nombre del archivo CSV
        $nombreArchivo = "{$nombreEmpresaSinEspacios}_empleados_{$fechaHora}.csv";
        
        // Define los encabezados para la descarga del archivo
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$nombreArchivo\"",
        ];
        
        // Devuelve el CSV como una respuesta
        return response()->stream(function () use ($csvData) {
            echo $csvData;
        }, 200, $headers);
    }
}
