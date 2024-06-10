<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\tbl_usuarios;
use App\Models\tbl_empresas; // Asegúrate de tener este modelo
use App\Models\tbl_pagos_empresa; // Asegúrate de tener este modelo
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser una dirección válida',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.max' => 'La contraseña no debe tener más de 20 caracteres',
        ]);

        // Buscar usuario por correo electrónico
        $user = tbl_usuarios::where('email', $credentials['email'])->first();

        if ($user && password_verify($credentials['password'], $user->contrasena)) {
            // Obtener el nombre de la empresa
            $empresa = tbl_empresas::find($user->id_empresa);

            // Iniciar sesión con variables de sesión
            $request->session()->put('id', $user->id);
            $request->session()->put('nombre', $user->nombre);
            $request->session()->put('apellidos', $user->apellidos);
            $request->session()->put('email', $user->email);
            $request->session()->put('rol', $user->id_rol);
            $request->session()->put('empresa', $user->id_empresa);
            $request->session()->put('nombre_empresa', $empresa->nombre); 

            $inicio_mes = date('Y-m-01 00:00:00'); // Primer día del mes actual a las 00:00:00 horas
            $fin_mes = date('Y-m-t 23:59:59'); // Último día del mes actual a las 23:59:59 horas
            
            $inicio_mes = date('Y-m-01 00:00:00'); // Primer día del mes actual a las 00:00:00 horas
            $fin_mes = date('Y-m-t 23:59:59'); // Último día del mes actual a las 23:59:59 horas
            
            $pagos = tbl_pagos_empresa::where('empresa', $user->id_empresa)
                ->where('fecha_pago', '>=', $inicio_mes)
                ->where('fecha_pago', '<=', $fin_mes)
                ->get();
                if ($pagos->count() > 0) {
                    $request->session()->put('pago', 'si');
                }   
                         
            if ($user->id_rol == 1) {
                return view('admin.admin');
            }
            elseif ($user->id_rol == 2 && $pagos->count() > 0) {
                return redirect()->route('gestEmpleados');
            }
            elseif ($user->id_rol == 3/*  && $pagos->count() > 0 */){
                return view('vistas.trabajador');
            }
            elseif ($user->id_rol==3 && $pagos->count() == 0){
                return redirect()->route('login')->with('success', 'La suscripcion mensual ha caducado. Tu gestor tiene que renovarla.');
            }
            elseif ($user->id_rol == 2 && $pagos->count() == 0){
                return view('vistas.pagos');
            }

        } else {
            // Si las credenciales son incorrectas, redirigir con mensaje de error
            return redirect()->route('login')->with('error', 'Credenciales incorrectas')->withInput();
        }
    }

    public function logout(Request $request)
    {
        // Limpiar variables de sesión y redirigir a la página de login
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}
