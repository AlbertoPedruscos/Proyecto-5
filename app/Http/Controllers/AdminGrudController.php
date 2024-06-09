<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_usuarios;
use App\Models\tbl_empresas;
use App\Models\tbl_roles;

class AdminGrudController extends Controller
{
    public function adminclientes(Request $request)
    {
        $roles = tbl_roles::all();
        $empresas = tbl_empresas::all();
        $usuarios = tbl_usuarios::join('tbl_empresas as e', 'tbl_usuarios.id_empresa', '=', 'e.id')
            ->join('tbl_roles as r', 'tbl_usuarios.id_rol', '=', 'r.id')
            ->select('tbl_usuarios.*', 'e.nombre as nom_empresa', 'r.nombre as nom_rol')
            ->where(function ($query) {
                $query->where('tbl_usuarios.id_rol', 1)
                    ->orWhere('tbl_usuarios.id_rol', 2);
            })
            ->orderBy('tbl_usuarios.id_rol', 'asc');
        if ($request->input('nombre')) {
            $nombre = $request->input('nombre');
            $usuarios->where('tbl_usuarios.nombre', 'like', "%$nombre%");
        }
        if ($request->input('rol')) {
            if ($request->input('rol') != "[object KeyboardEvent]") {
                $rol = $request->input('rol');
                $usuarios->where('tbl_usuarios.id_rol', $rol);
            }
        }
        $usuarios = $usuarios->get();
        return response()->json(['usuarios' => $usuarios, 'empresas' => $empresas, 'roles' => $roles]);
    }


    public function admineditar(Request $request)
    {
        $id = $request->input('idp');
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');
        $empresa = $request->input('empresa');

        $resultado = tbl_usuarios::find($id);
        $resultado->nombre = $nombre;
        $resultado->apellidos = $apellidos;
        $resultado->email = $nombre . "." . $apellidos . "@" . $request->input('EmpresaNombre') . ".com";
        $resultado->id_rol = 2;
        $resultado->id_empresa = $empresa;
        $resultado->save();
        echo "ok";
    }


    public function admineliminar(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $resultado = tbl_usuarios::find($id);
                if ($resultado) {
                    $resultado->delete();
                }
            }
            echo "ok";
        } else {
            $resultado = tbl_usuarios::find($ids);
            $resultado->delete();
            echo "ok";
        }
    }

    public function adminregistrar(Request $request)
    {
        $nombre = $request->input('nombreuser');
        $apellidos = $request->input('apellido');
        $pwdencrip = bcrypt("$request->input('pwd')");
        $SelecRoles = $request->input('SelecRoles');
        $SelecEmpresa = $request->input('SelecEmpresa');
        $nombreEmpresa = $request->input('nombre_empresa');


        $resultado = new tbl_usuarios();
        $resultado->nombre = $nombre;
        $resultado->apellidos = $apellidos;
        $resultado->email = $nombre . "." . $apellidos . "@" . $nombreEmpresa . ".com";
        $resultado->contrasena = $pwdencrip;
        $resultado->id_rol = $SelecRoles;
        $resultado->id_empresa = $SelecEmpresa;
        $resultado->save();
        
        echo "ok";
    }

    // Grud empresas

    public function adminempresas(Request $request)
    {
        $empresas = tbl_empresas::query();

        if ($request->input('nombre')) {
            $nombre = $request->input('nombre');
            $empresas->where('nombre', 'like', "%$nombre%");
        }

        $empresas = $empresas->get();

        return response()->json($empresas);
    }

    public function adminempresaseditar(Request $request)
    {
        $id = $request->input('idp');
        $nombre = $request->input('nombre');

        // Buscar empresas con el mismo nombre
        $empresas = tbl_empresas::where('nombre', 'like', $nombre)->get();

        if ($empresas->isEmpty()) {
            // Si no hay empresas con el mismo nombre, actualizar la empresa existente
            $resultado = tbl_empresas::find($id);
            if ($resultado) {
                $usuarios = tbl_usuarios::where('id_empresa', $id)->get();
                if ($usuarios) {
                    foreach ($usuarios as $usuario) {
                        $email = $usuario->email;
                        $newemail = explode("@", $email)[1];
                        $newemail2 = explode(".", $newemail)[0];
                        $usuario->email = str_replace($newemail2, $nombre, $usuario->email);
                        $usuario->save();
                    }
                }
                $resultado->nombre = $nombre;
                $resultado->save();
                echo "ok";
            }
        } else {
            echo "existe";
        }
    }

    public function adminempresaseliminar(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $resultado = tbl_empresas::find($id);
                if ($resultado) {
                    $resultado->delete();
                }
            }
            echo "ok";
        } else {
            $resultado = tbl_empresas::find($ids);
            if ($resultado) {
                $resultado->delete();
                echo "ok";
            }
        }
    }

    public function adminempresasregistrar(Request $request)
    {
        $nombre = $request->input('nombreuser');

        $existingEmpresa = tbl_empresas::where('nombre', $nombre)->first();

        if (!$existingEmpresa) {
            $resultado = new tbl_empresas();
            $resultado->nombre = $nombre;
            $resultado->save();
            echo "ok";
        } else {
            echo "existe";
        }
    }

    public function store(Request $request)
    {
        $nombre = $request->input('nombreuser');

        $existingEmpresa = tbl_empresas::where('nombre', $nombre)->first();

        if (!$existingEmpresa) {
            $resultado = new tbl_empresas();
            $resultado->nombre = $nombre;
            $resultado->save();
            return redirect()->route('admin_empresa')->with('success', 'Empresa registrada correctamente.');
        } 
        
        else {
            return redirect()->route('admin_empresa')->with('error', 'La empresa ya existe.');
        }
    }
}
