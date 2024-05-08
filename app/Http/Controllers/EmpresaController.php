<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Asegúrate de importar la clase Request
use App\Models\tbl_usuarios;
use App\Models\tbl_empresas;
use App\Models\tbl_roles;

class EmpresaController extends Controller
{
    public function listarreservas(Request $request)
    {
        $roles = tbl_roles::all();
        $empresas = tbl_empresas::all();
        $empresa = session('id_empresa');
        $usuarios = tbl_usuarios::join('tbl_empresas as e', 'tbl_usuarios.id_empresa', '=', 'e.id')
            ->join('tbl_roles as r', 'tbl_usuarios.id_rol', '=', 'r.id')
            ->select('tbl_usuarios.*', 'e.nombre as nom_empresa', 'r.nombre as nom_rol')
            ->where('tbl_usuarios.id_empresa', $empresa);
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
        $usuarios = $usuarios->get(); // Obtener resultados de la consulta
        return response()->json(['usuarios' => $usuarios, 'empresas' => $empresas, 'roles' => $roles]);
    }



    public function estado(Request $request)
    {
        $id = $request->input('idp');
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');
        $email = $request->input('email');
        $rol = $request->input('rol');

        $resultado = tbl_usuarios::find($id);
        $resultado->nombre = $nombre;
        $resultado->apellidos = $apellidos;
        $resultado->email = $email;
        $resultado->id_rol = $rol;
        $resultado->save();
        echo "ok";
    }

    public function eliminar(Request $request)
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

    public function registrar(Request $request)
    {
        $empresa = session('id_empresa');

        $nombre = $request->input('nombreuser');
        $apellidos = $request->input('apellido');
        $email = $request->input('email');
        $pwdencrip = bcrypt($request->input('email'));
        // $pwd = $request->input('pwd');
        $SelecRoles = $request->input('SelecRoles');



        $resultado = new tbl_usuarios();
        $resultado->nombre = $nombre;
        $resultado->apellidos = $apellidos;
        $resultado->email = $email;
        $resultado->contrasena = $pwdencrip;
        $resultado->id_rol = $SelecRoles;
        $resultado->id_empresa = $empresa;
        $resultado->save();
        echo "ok";
    }
}
