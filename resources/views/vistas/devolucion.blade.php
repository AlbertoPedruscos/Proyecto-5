<?php
use Illuminate\Support\Facades\Session;
$variable_de_sesion = session('id') ?? null;
$pago = session('pago') ?? null;
$rol = session('rol') ?? null;

if ($variable_de_sesion !== null && $pago === 'si' && $rol == 3) {
    // Código que quieres ejecutar si las condiciones se cumplen
} else {
    echo "<script>
        window.location.href = '/';
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Document</title>
    <link rel="stylesheet" href="./css/devolucion.css">
</head>
<body>
    <a href="/trabajador" class="rojo">Volver</a>
    <br>
    <br>
    <br>
    <label for="firma">Codigo del cliente:</label>
    <input id="codigo" class="inputs"></canvas>
    <br>
    <button onclick="codigoSal()" class="azul">Enviar</button>
    <br>
    <br>
    <label for="firma">Firma del cliente:</label>
    <canvas id="canvas" class="canvas"></canvas>
    <br>
    <br>
    <button class="naranja" onclick="limpiarCanvas()">Limpiar Firma</button>
    <button class="azul" onclick="mostrarDatosReserva()">Ver datos de la reserva</button>
    <br>
    <br>
    <br>
    <div id="datosReserva">

    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/devolucion.js"></script>