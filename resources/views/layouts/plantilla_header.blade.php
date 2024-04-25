<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyControlPark')</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
    <!-- CSS personalizado -->
    @yield('css')
    <!-- Icono -->
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    {{-- CRSF token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @yield('content') <!-- Sección para el contenido -->
</body>

</html>
