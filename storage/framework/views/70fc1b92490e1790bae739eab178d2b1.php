<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
    <title>Empresa</title>
    <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/empresa.css')); ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    
    <div class="contenedor">
        
        <h1>MyControlPark</h1>
        
        <button id="menu" class="btnregister">Registrar <i class="fas fa-user-circle"></i></button>
        <a class="navbar-brand" href="logout" class="dropdown-item">Cerrar sesión</a>
    </div>
    


    <div class="col-lg-12 ml-auto" style="border:1px solid">
        <form action="" method="post" id="frmbusqueda">
            <div class="form-group">
                <label for="nombre">nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Buscar...">
            </div>
        </form>
    </div>
    <div id="rolfiltros">
        <form action="" method="post" id="frmfiltroRol">
            <label for="rol">Rol:</label><br>
            <select name="filtroRol" id="filtroRol">
            </select>
        </form>
        <div>
            <button onclick="selectmuldel()">Eliminar seleccion</button>
        </div>
    </div>

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
            <p>Nombre</p>
            <input type="text" name="nombreuser" id="nombreuser">
            <p>Apellido</p>
            <input type="text" name="apellido" id="apellido">
            <p>Email</p>
            <input type="text" name="email" id="email">
            <p>pwd</p>
            <input type="password" name="pwd" id="pwd">
            <p>Rol</p>
            <p><select name="SelecRoles" id="SelecRoles">
                </select></p>
            <p><input type="button" value="registrar" id="registrar"></p>
        </form>
    </div>

</body>
<script src="<?php echo e(asset('/js/empresa.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
<?php /**PATH C:\xampp\htdocs\Daw\m12\Proyecto-5\resources\views/empresa/empresa.blade.php ENDPATH**/ ?>