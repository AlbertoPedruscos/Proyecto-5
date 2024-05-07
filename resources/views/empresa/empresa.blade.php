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
    <link rel="stylesheet" href="{{ asset('css/indice.css') }}">
</head>

<body>
    {{-- <header> --}}
    <div class="contenedor">
        <p id="menu"><i class="fas fa-grip-lines"></i></p>
        <h1>MyControlPark</h1>
        <a href="{{ asset('/login') }}"><i class="fas fa-user-circle"></i></a>
    </div>

    {{-- </header> --}}

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>seleccionar</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody id="resultado"></tbody>
    </table>

    <div class="sub-menu1-container" id="submenu" style="display: none;">
        <form action="" method="post" id="formnewuser">
            <input type="hidden" name="idp" id="idp">
            <p>Nombre</p>
            <input type="text" name="nombre" id="nombre">
            <p>Apellido</p>
            <input type="text" name="apellido" id="apellido">
            <p>Email</p>
            <input type="text" name="email" id="email">
            <p>Rol</p>
            <input type="text" name="rol" id="rol">
            <p><input type="button" value="registrar" id="registrar"></p>
        </form>
    </div>

</body>
<script src="{{ asset('/js/empresa.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
