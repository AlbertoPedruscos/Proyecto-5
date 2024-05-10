<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyControlPark</title>
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

    <div class="contenedor1">
        <h2>¿Buscas una mejor gestión para tus parkings?</h2>
        <button>Únete</button>
    </div>

    <div class="contenedor2">
        <h3>Contamos con todo lo que necesitas</h3>
        <ol>
            <li>Una excelente organización de tus parkings</li>
        </ol>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var nav = document.getElementById('menu');
            var submenu = document.getElementById('submenu');

            nav.addEventListener('click', function() {
                submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/welcome.blade.php ENDPATH**/ ?>