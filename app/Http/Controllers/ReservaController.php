<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modeloReserva; // Asegúrate de importar el modelo adecuado
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{
    public function reservaO(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nom_cliente' => 'required|string|max:45',
            'matricula' => 'required|string|max:10',
            'marca' => 'required|string|max:15',
            'modelo' => 'required|string|max:20',
            'color' => 'required|string|max:15',
            'num_telf' => ['required', 'regex:/^[0-9]{9}$/'],
            'email' => 'required|email|max:45',
            'ubicacion_entrada' => 'required|string|max:20',
            'ubicacion_salida' => 'required|string|max:20',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date',
        ]);

        // Generar un ID aleatorio de 20 dígitos y verificar si ya existe
        do {
            $id = '';
            for ($i = 0; $i < 16; $i++) {
                $id .= rand(0, 9);
            }
        } while (modeloReserva::where('id', $id)->exists());

        // Crear una nueva reserva utilizando el modelo
        $reserva = new modeloReserva();
        $reserva->id = $id;
        $reserva->nom_cliente = $request->nom_cliente;
        $reserva->matricula = $request->matricula;
        $reserva->marca = $request->marca;
        $reserva->modelo = $request->modelo;
        $reserva->color = $request->color;
        $reserva->num_telf = $request->num_telf;
        $reserva->email = $request->email;
        $reserva->ubicacion_entrada = $request->ubicacion_entrada;
        $reserva->ubicacion_salida = $request->ubicacion_salida;
        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->fecha_salida = $request->fecha_salida;
        $reserva->save();

        // Envio de correo
        // $sujeto = $request->get('nombre');
        $sujeto = "Codigo de Reserva";
        $nombre_cliente = $request->nom_cliente;
        // $nombreRemitente = $request->nombre;
        // $mensaje = $request->mensaje;
        $correoDestinatario = $request->email;

        Mail::send('correo.vistacorreo', [
            // 'nombre' => $nombreRemitente,
            'correo' => $correoDestinatario,
            'nombre_cliente' => $nombre_cliente,
            'codigo_reserva' => $id
        ], function ($message) use ($correoDestinatario, $sujeto) {
            $message->to($correoDestinatario)
                ->subject($sujeto);
        });

        echo "ok";
    }
}
