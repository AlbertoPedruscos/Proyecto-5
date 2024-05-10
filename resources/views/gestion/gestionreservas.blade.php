<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Empresa</title>
    <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
    {{-- FUENTE --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <ul class="nav-left">
                <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                <li><a href="{{ route('empleados') }}">Empleados</a></li>
                <li class="active">Reservas</li>
                <li><a href="{{ 'mapa' }}">Mapa</a></li>
            </ul>

            <ul class="nav-right">
                <!-- Mostrar el nombre del usuario -->
                <li>{{ session('nombre') }}</li>

                <!-- Mostrar el nombre de la empresa, si está disponible -->
                @if (session('nombre_empresa'))
                    <li>{{ session('nombre_empresa') }}</li>
                @else
                    <li>Empresa no asignada</li> <!-- Mensaje alternativo si no hay empresa -->
                @endif

                <!-- Enlace para cerrar sesión -->
                <li><a href="{{ route('logout') }}">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <button id="menu" class="btnregister">Registrar <i class="fas fa-user-circle"></i></button>

    <div class="col-lg-12 ml-auto" style="border:1px solid">
        <form action="" method="post" id="frmbusqueda">
            <div class="form-group">
                <label for="nombre">nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Buscar...">
            </div>
        </form>
    </div>
    <div>
        <button onclick="selectmuldel()">Eliminar seleccion</button>
    </div>

    <div>
        <div id="expirados" style="border:solid 2px; margin: 10px; padding:10px; float:right; "></div>
        <div id="activos" style="border:solid 2px; margin: 10px; padding:10px; float:right; "></div>
        <div id="nuevos" style="border:solid 2px; margin: 10px; padding:10px; float:right; "></div>
    </div>

</body>
<script src="{{ asset('/js/reservas.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
