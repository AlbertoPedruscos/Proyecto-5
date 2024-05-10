<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_usuarios;
use App\Models\tbl_roles;
use App\Models\tbl_reservas;

class ReservasGrudController extends Controller
{
    public function listarreservas()
    {
        $empresa = session('id_empresa');
        // $reservas = tbl_reservas::all();
        $reservas = tbl_reservas::leftJoin('tbl_usuarios as u', 'tbl_reservas.id_trabajador', '=', 'u.id')
            ->leftJoin('tbl_plazas as p', 'tbl_reservas.id_plaza', '=', 'p.id')
            ->leftJoin('tbl_parkings as pakg', 'p.id_parking', '=', 'pakg.id')
            ->leftJoin('tbl_empresas as e', 'pakg.id_empresa', '=', 'e.id')
            ->select('tbl_reservas.*', 'u.nombre as trabajador', 'p.nombre as plaza', 'pakg.nombre as parking', 'e.nombre as empresa')
            ->orderby('tbl_reservas.fecha_entrada', 'asc')
            ->where('e.id', 1);
        $reservas = $reservas->get();
        // return response()->json(['reservas' => $reservas, 'roles' => $roles]);
        return response()->json($reservas);
    }



    public function estado(Request $request)
    {
        $id = $request->input('idp');
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');
        $email = $request->input('email');
        $rol = $request->input('rol');

        $resultado = tbl_reservas::find($id);
        $resultado->nombre = $nombre;
        $resultado->apellidos = $apellidos;
        $resultado->email = $email;
        $resultado->id_rol = $rol;
        $resultado->save();
        echo "ok";
    }

    public function CancelarReserva(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $resultado = tbl_reservas::find($id);
                if ($resultado) {
                    $resultado->delete();
                }
            }
            echo "ok";
        } else {
            $resultado = tbl_reservas::find($ids);
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

        $resultado = new tbl_reservas();
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
