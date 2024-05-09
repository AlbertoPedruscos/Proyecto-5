<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_usuarios;
use App\Models\tbl_empresas;
use App\Models\tbl_roles;
use App\Models\tbl_reservas;

class ReservasGrudController extends Controller
{
    public function listarreservas(Request $request)
    {
        $roles = tbl_roles::all();
        $reservas = tbl_reservas::leftJoin('tbl_usuarios as u', 'tbl_reservas.id_trabajador', '=', 'u.id')
            ->leftJoin('tbl_plazas as p', 'tbl_reservas.id_plaza', '=', 'p.id')
            ->leftJoin('tbl_parking as pakg', 'p.id_parking', '=', 'pakg.id')
            ->leftJoin('tbl_empresas as e', 'pakg.id_empresa', '=', 'e.id')
            ->select('tbl_reservas.*', 'u.nombre as trabajador', 'p.nombre as plaza', 'pakg.nombre as parking', 'e.nombre as empresa');
        $reservas = $reservas->get();

        // $empresa = session('id_empresa');

        return response()->json(['reservas' => $reservas, 'roles' => $roles]);
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
