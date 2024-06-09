<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_reservas;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function reservaO(Request $request)
    {
        // Validar datos recibidos
        $request->validate([
            'nom_cliente' => 'required|string',
            'matricula' => 'required|string',
            'cochesSelect' => 'required|string',
            'modelo' => 'required|string',
            'color' => 'required|string',
            'prefijo' => 'required|string',
            'num_telf' => 'required|string',
            'email' => 'required|email',
            'ubicacion_entrada' => 'required|string',
            'ubicacion_salida' => 'required|string',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date',
        ]);
    
        // Generar un ID aleatorio de 20 dígitos y verificar si ya existe
        do {
            $id = '';
            for ($i = 0; $i < 16; $i++) {
                $id .= rand(0, 9);
            }
        } while (tbl_reservas::where('id', $id)->exists());
    
        try {
            // Crear una nueva reserva utilizando el modelo
            $reserva = new tbl_reservas();
            $reserva->id = $id;
            $reserva->nom_cliente = $request->nom_cliente;
            $reserva->matricula = $request->matricula;
            $reserva->marca = $request->cochesSelect;
            $reserva->modelo = $request->modelo;
            $reserva->color =  $request->color;
            $reserva->num_telf = $request->prefijo . $request->num_telf;
            $reserva->email = $request->email;
            $reserva->ubicacion_entrada = $request->ubicacion_entrada;
            $reserva->ubicacion_salida = $request->ubicacion_salida;
            $reserva->fecha_entrada = $request->fecha_entrada;
            $reserva->fecha_salida = $request->fecha_salida;
            $reserva->save();
    
            // Envio de correo
            $sujeto = "Codigo de Reserva";
            $correoDestinatario = $request->email;
            $fechaEntrada = Carbon::parse($request->fecha_entrada);
            $fechaSalida = Carbon::parse($request->fecha_salida);
    
            // Separar fecha y hora para fecha_entrada
            $fechaEntradaFecha = $fechaEntrada->format('d-m-Y');
            $fechaEntradaHora = $fechaEntrada->format('H:i:s');
    
            // Separar fecha y hora para fecha_salida
            $fechaSalidaFecha = $fechaSalida->format('d-m-Y');
            $fechaSalidaHora = $fechaSalida->format('H:i:s');
    
            Mail::send('correo.vistacorreo', [
                'nombre_cliente' => $request->nom_cliente,
                'codigo_reserva' => $id,
                'ubicacion_entrada' => $request->textoubicacion_entrada,
                'ubicacion_salida' => $request->textoubicacion_salida,
                'fechaEntradaFecha' => $fechaEntradaFecha,
                'fechaEntradaHora' => $fechaEntradaHora,
                'fechaSalidaFecha' => $fechaSalidaFecha,
                'fechaSalidaHora' => $fechaSalidaHora
            ], function ($message) use ($correoDestinatario, $sujeto) {
                $message->to($correoDestinatario)
                    ->subject($sujeto);
            });
    
            echo "ok";
        } catch (\Exception $e) {
            // Log de errores
            \Log::error('Error al crear reserva: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear la reserva'], 500);
        }
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
