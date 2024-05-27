<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_reservas;
use Illuminate\Support\Facades\Mail;
use DateTime;


class ReservaController extends Controller
{
    public function reservaO(Request $request)
{
    // Validaciones del formulario
    $request->validate([
        'nom_cliente' => 'required|string',
        'matricula' => 'required|regex:/^\d{4}[A-Za-z]{3}$|^[A-Za-z]{2}\d{3}[A-Za-z]{2}$|^[A-Za-z]{2}\d{4}[A-Za-z]{2}$|^[A-Za-z]{1}\d{4}$|^[A-Za-z]{2}\d{3}[A-Za-z]{1}$|^[A-Za-z]{2}\d{2}[A-Za-z]{3}$|^[A-Za-z]{2}\d{6}$|^\d{1}[A-Za-z]{3}\d{2}$/',
        'cochesSelect' => 'required|string',
        'modelo' => 'required|string',
        'color' => 'required|string',
        'prefijo' => 'required|string',
        'num_telf' => 'required|regex:/^\d{9}$/',
        'email' => 'required|email',
        'ubicacion_entrada' => 'required|string',
        'ubicacion_salida' => 'required|string',
        'fecha_entrada' => 'required|date|after_or_equal:now',
        'fecha_salida' => 'required|date|after:fecha_entrada',
        'invalidCheck2' => 'accepted'
    ]);

    // Validar que la fecha de entrada sea anterior a la fecha de salida con al menos 5 horas de diferencia
    $fechaEntrada = new DateTime($request->fecha_entrada);
    $fechaSalida = new DateTime($request->fecha_salida);
    $fechaActual = new DateTime();

    // Verificar que las fechas no sean anteriores a la fecha actual
    if ($fechaEntrada < $fechaActual) {
        return response()->json(['error' => 'La fecha de entrada no puede ser anterior a la fecha actual.'], 400);
    }

    // Verificar que la fecha de salida sea al menos 5 horas después de la fecha de entrada
    $interval = $fechaEntrada->diff($fechaSalida);
    if ($interval->h < 5 && $interval->days === 0) {
        return response()->json(['error' => 'La fecha de salida debe ser al menos 5 horas después de la fecha de entrada.'], 400);
    }

    // Generar un ID aleatorio de 16 dígitos y verificar si ya existe
    do {
        $id = '';
        for ($i = 0; $i < 16; $i++) {
            $id .= rand(0, 9);
        }
    } while (tbl_reservas::where('id', $id)->exists());

    // Crear una nueva reserva utilizando el modelo
    $reserva = new tbl_reservas();
    $reserva->id = $id;
    $reserva->nom_cliente = $request->nom_cliente;
    $reserva->matricula = $request->matricula;
    $reserva->marca = $request->cochesSelect;
    $reserva->modelo = $request->modelo;
    $reserva->color = $request->color;
    $reserva->num_telf = $request->prefijo . $request->num_telf;
    $reserva->email = $request->email;
    $reserva->ubicacion_entrada = $request->ubicacion_entrada;
    $reserva->ubicacion_salida = $request->ubicacion_salida;
    $reserva->fecha_entrada = $request->fecha_entrada;
    $reserva->fecha_salida = $request->fecha_salida;
    $reserva->save();

    // Envío de correo
    $sujeto = "Codigo de Reserva";
    $correoDestinatario = $request->email;

    Mail::send('correo.vistacorreo', [
        'nombre_cliente' => $request->nom_cliente,
        'codigo_reserva' => $id
    ], function ($message) use ($correoDestinatario, $sujeto) {
        $message->to($correoDestinatario)
            ->subject($sujeto);
    });

    return response()->json(['message' => 'Reserva realizada con éxito', 'codigo_reserva' => $id], 200);
}

    public function Contactanos(Request $request)
    {
        // Envio de correo
        // $sujeto = $request->get('nombre');
        $sujeto = "Informacion empresa";
        // $nombre_cliente = $request->nom_cliente;
        // $nombreRemitente = $request->nombre;
        // $mensaje = $request->mensaje;
        $correoDestinatario = "mycontrolpark@gmail.com";

        Mail::send('correo.contactanos', [
            'nom_cliente' => $request->nom_cliente,
            'apellidos' => $request->apellidos,
            'prefijo' => $request->prefijo,
            'num_telf' => $request->num_telf,
            'email' => $request->email,
            'mensaje' => $request->mensaje
        ], function ($message) use ($correoDestinatario, $sujeto) {
            $message->to($correoDestinatario)
                ->subject($sujeto);
        });

        echo "ok";
    }
}
