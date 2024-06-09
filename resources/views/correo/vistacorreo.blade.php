<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- FUENTE --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <h1>MyControlPark</h1>
    <p>Hola {{ $nombre_cliente }} Gracias por confiar consotros para hacer tu reserva.</p>
    <p>Su codigo de reserva es: {{ $codigo_reserva }}.</p>
    <p>Nos vemos para la recogida en: {{ $ubicacion_entrada }} el dia: {{ $fechaEntradaFecha }} a las:
        {{ $fechaEntradaHora }}</p>
    <p>Le devolvemos el coche en: {{ $ubicacion_salida }} el dia: {{ $fechaSalidaFecha }} a las:
        {{ $fechaSalidaHora }}</p>
</body>

</html>
