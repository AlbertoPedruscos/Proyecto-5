<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_usuarios;
use App\Models\tbl_parking;
use App\Models\tbl_plazas;
use App\Models\tbl_reservas;
use App\Models\tbl_ubicaciones;

class ReservasGrudController extends Controller
{
    public function listarreservas()
    {
        $empresa = session('empresa');
        $usuarios = tbl_usuarios::where('id_empresa', $empresa)->get();
        $parkings = tbl_parking::where('id_empresa', $empresa)->get();
        $ubicaciones = tbl_ubicaciones::all();
        foreach ($parkings as $parking) {
            $plazas[$parking->id] = tbl_plazas::where('id_parking', $parking->id)->get();
        }

        // $plazas = tbl_plazas::all();

        $reservas = tbl_reservas::leftJoin('tbl_usuarios as u', 'tbl_reservas.id_trabajador', '=', 'u.id')
            ->leftJoin('tbl_plazas as p', 'tbl_reservas.id_plaza', '=', 'p.id')
            ->leftJoin('tbl_parkings as pakg', 'p.id_parking', '=', 'pakg.id')
            ->leftJoin('tbl_empresas as e', 'pakg.id_empresa', '=', 'e.id')
            ->select('tbl_reservas.*', 'u.nombre as trabajador', 'p.nombre as plaza', 'pakg.nombre as parking', 'e.nombre as empresa')
            ->orderby('tbl_reservas.fecha_entrada', 'asc')
            ->where('e.id', 2);
        $reservas = $reservas->get();
        // return response()->json(['reservas' => $reservas, 'usuarios' => $usuarios, 'parkings' => $parkings]);

        return response()->json(['reservas' => $reservas, 'usuarios' => $usuarios, 'parkings' => $parkings, 'plazas' => $plazas, 'ubicaciones' => $ubicaciones]);
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
        $id = $request->input('id');
        // echo $id;
        $resultado = tbl_reservas::find($id);
        $resultado->delete();
        echo "ok";
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

    public function ReservasEditar(Request $request)
    {
        $id = $request->input('idp');
        $nombre = $request->input('nombre');
        if ($request->input('trabajador') == 0) {
            $trabajador = NULL;
        } else {
            $trabajador = $request->input('trabajador');
        }
        if ($request->input('plaza') == 0) {
            $plaza = NULL;
        } else {
            $plaza = $request->input('plaza');
        }
        $matricula = $request->input('matricula');
        if ($request->input('marca') == 0) {
            $marca = NULL;
        } else {
            $marca = $request->input('marca');
        }
        $modelo = $request->input('modelo');
        $color = $request->input('color');
        $telf = $request->input('telf');
        $email = $request->input('email');
        if ($request->input('puntorecogida') == 0) {
            $recogida = NULL;
        } else {
            $recogida = $request->input('puntorecogida');
        }
        if ($request->input('puntoentrega') == 0) {
            $entrega = NULL;
        } else {
            $entrega = $request->input('puntoentrega');
        }
        $fechaentrada = $request->input('fechaentrada');
        $fechasalida = $request->input('fechasalida');

        $resultado = tbl_reservas::find($id);
        $resultado->nom_cliente = $nombre;
        $resultado->id_trabajador = $trabajador;
        $resultado->id_plaza = $plaza;
        $resultado->matricula = $matricula;
        $resultado->marca = $marca;
        $resultado->modelo = $modelo;
        $resultado->color = $color;
        $resultado->num_telf = $telf;
        $resultado->email = $email;
        $resultado->ubicacion_entrada = $recogida;
        $resultado->ubicacion_salida = $entrega;
        $resultado->fecha_entrada = $fechaentrada;
        $resultado->fecha_salida = $fechasalida;
        $resultado->save();
        echo "ok";
    }

    public function listarreservascsv()
    {
        // Obtener todos los datos desde la base de datos
        $datos = tbl_reservas::all();
        return response()->json($datos);
    }
}
