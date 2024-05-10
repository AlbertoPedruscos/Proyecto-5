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
    <link rel="stylesheet" href="<?php echo e(asset('css/indice.css')); ?>">
</head>

<body>
    
    <div class="contenedor">
        <p id="menu"><i class="fas fa-grip-lines"></i></p>
        <h1>MyControlPark</h1>
        <a href="<?php echo e(asset('/login')); ?>"><i class="fas fa-user-circle"></i></a>
    </div>

    <div class="sub-menu1-container" id="submenu">
        <ul>
            <li><a href="">Chat</a></li>
            <li><a href="">Mapa</a></li>
            <li><a href="">Lista de Llamadas</a></li>
            <li><a href="">Ajustes</a></li>
        </ul>
    </div>
    

    <table>
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Cliente</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Rol</th>
                <th>Empresa</th>
            </tr>
        </thead>
        <tbody id="resultado"></tbody>
    </table>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var nav = document.getElementById('menu');
        var submenu = document.getElementById('submenu');

        nav.addEventListener('click', function() {
            submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
<script src="<?php echo e(asset('/js/script.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/vistas/empresa.blade.php ENDPATH**/ ?>