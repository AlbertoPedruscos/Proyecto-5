<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\tbl_pagos_empresa;
use Stripe\Exception\CardException;
// use Carbon\Carbon;


class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $charge = Charge::create([
                'amount' => 100, // 1 euro en centavos
                'currency' => 'eur',
                'description' => 'Descripción del pago',
                'source' => $request->stripeToken,
            ]);

            $pago = new tbl_pagos_empresa();
            $pago->empresa = session('empresa'); // ID de la empresa que ha hecho el pago
            $pago->ha_hecho_pago = true; // Indicar que la empresa ha hecho el pago
            $pago->fecha_pago = now(); // Establecer la fecha actual como fecha de pago
            $pago->save();

            session(['success_message' => 'Pago realizado con éxito']);
        } catch (CardException $e) {
            // Si ocurre un error con el pago
            session(['error_message' => 'Datos erróneos']);
        }
    
        // Retornar a la vista anterior
        return view('vistas.pagos');
    }
    // // Función para crear un PaymentIntent en Stripe
    // public function procesarPago(Request $request)
    // {
    //     // Obtener las fechas de entrega y recogida del formulario
    //     $fechaEntrega = Carbon::parse($request->fechaEntrega);
    //     $fechaRecogida = Carbon::parse($request->fechaRecogida);

    //     // Calcular la diferencia de días entre las fechas
    //     $dias = $fechaRecogida->diffInDays($fechaEntrega);

    //     // Precio fijo por día
    //     $precioFijoPorDia = 100; // Puedes ajustar este valor según tus necesidades

    //     // Calcular el precio total
    //     $precioTotal = $dias * $precioFijoPorDia; // Convertir el precio a centavos

    //     // Configurar la clave secreta de Stripe
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     try {
    //         // Crea un cargo en Stripe
    //         $charge = Charge::create([
    //             'amount' => $precioTotal, // Convertir el precio a centavos
    //             'currency' => 'usd', // Cambiar según la moneda que estés utilizando
    //             'description' => 'Descripción del pago', // Puedes cambiar esto según tus necesidades
    //             'source' => $request->stripeToken,
    //         ]);

    //         // Devuelve una respuesta de éxito
    //         return response()->json(['message' => 'Pago procesado exitosamente']);
    //     } catch (CardException $e) {
    //         // Maneja errores específicos de Stripe (como problemas con la tarjeta)
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     } catch (\Exception $e) {
    //         // Maneja cualquier otro error que ocurra durante el proceso de pago
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
}

