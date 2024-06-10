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
    public function listarreservas(Request $request)
    {

        $empresa = session('empresa');
        $usuarios = tbl_usuarios::where('id_empresa', $empresa)->get();
        $parkings = tbl_parking::where('id_empresa', $empresa)->get();
        $ubicaciones = tbl_ubicaciones::where('empresa', $empresa)->get();
        foreach ($parkings as $parking) {
            $plazas[$parking->id] = tbl_plazas::where('id_parking', $parking->id)->get();
        }
        
        $reservas = tbl_reservas::leftJoin('tbl_usuarios as u', 'tbl_reservas.id_trabajador', '=', 'u.id')
            ->leftJoin('tbl_plazas as p', 'tbl_reservas.id_plaza', '=', 'p.id')
            ->leftJoin('tbl_parkings as pakg', 'p.id_parking', '=', 'pakg.id')
            ->leftJoin('tbl_empresas as e', 'pakg.id_empresa', '=', 'e.id')
            ->select('tbl_reservas.*', 'u.nombre as trabajador', 'p.nombre as plaza', 'pakg.nombre as parking', 'pakg.id as parking_id', 'e.nombre as empresa')
            ->orderby('tbl_reservas.fecha_entrada', 'asc');
            
        if ($request->input('matrica')) {
            $matrica = $request->input('matrica');
            $reservas = $reservas->where('matricula', 'like', "%$matrica%");
        }

        if ($request->input('fachaini')) {
            $fachaini = $request->input('fachaini');
            $reservas = $reservas->where('fecha_entrada', 'like', "%$fachaini%");
        }

        if ($request->input('fachafin')) {
            $fachafin = $request->input('fachafin');
            $reservas = $reservas->where('fecha_salida', 'like', "%$fachafin%");
        }

        $reservas = $reservas->where('e.id', $empresa)->get();


        return response()->json(['reservas' => $reservas, 'usuarios' => $usuarios, 'parkings' => $parkings, 'plazas' => $plazas, 'ubicaciones' => $ubicaciones]);
    }

    public function CancelarReserva(Request $request)
    {
        $id = $request->input('id');
        $resultado = tbl_reservas::find($id);

        if (!$resultado) {
            echo 'Reserva no encontrada';
        }

        $resultado->delete();
        echo "ok";
    }

    public function registrar(Request $request)
    {
        $empresa = session('id_empresa');
        $nombre = $request->input('nombreuser');
        $apellidos = $request->input('apellido');
        $email = $request->input('email');
        $pwdencrip = bcrypt($request->input('pwd'));
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
        $trabajador = $request->input('trabajador') ?: null;
        $plaza = $request->input('plaza') ?: null;
        $matricula = $request->input('matricula');
        $marca = $request->input('marca') ?: null;
        $modelo = $request->input('modelo');
        $color = $request->input('color');
        $telf = $request->input('telf');
        $email = $request->input('email');
        $recogida = $request->input('puntorecogida') ?: null;
        $entrega = $request->input('puntosalida') ?: null;
        $fechaentrada = $request->input('fechaentrada');
        $fechasalida = $request->input('fechasalida');

        $resultado = tbl_reservas::find($id);

        if (!$resultado) {
            echo "no encontrado";
        }

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
        $empresa = session('empresa');
        $datos = tbl_reservas::leftJoin('tbl_usuarios as u', 'tbl_reservas.id_trabajador', '=', 'u.id')
            ->leftJoin('tbl_plazas as p', 'tbl_reservas.id_plaza', '=', 'p.id')
            ->leftJoin('tbl_parkings as pakg', 'p.id_parking', '=', 'pakg.id')
            ->leftJoin('tbl_empresas as e', 'pakg.id_empresa', '=', 'e.id')
            ->leftJoin('tbl_ubicaciones as ubis', 'tbl_reservas.ubicacion_entrada', '=', 'ubis.id')
            ->leftJoin('tbl_ubicaciones as ubisali', 'tbl_reservas.ubicacion_salida', '=', 'ubisali.id')
            ->select('tbl_reservas.*', 'u.nombre as trabajador', 'p.nombre as plaza', 'pakg.nombre as parking', 'pakg.id as parking_id', 'e.nombre as empresa', 'ubis.nombre_sitio as ubicacion entrada', 'ubisali.nombre_sitio as ubicacion salida')
            ->orderBy('tbl_reservas.fecha_entrada', 'asc')
            ->where('e.id',  $empresa)
            ->get();
        // $datos = $datos->get();
        return response()->json($datos);
    }
}
