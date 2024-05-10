<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservas</title>
    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>">
</head>

<body>
    <h3>Bienvenido</h3>
    <p>Aqui puedes realizar tu reserva</p>
    <form action="/" method="post" id="frm">
        <p>Nombre</p>
        <p><input type="text" name="nom"></p>
        <p>Inicio</p>
        <input type="datetime-local" name="fechaini">
        <p>Fin</p>
        <input type="datetime-local" name="fechafin">
        <p>Firma</p>
        <input type="text" name="firma">
        <p><input type="submit" value="Reservar" id="registrar"></p>
    </form>

    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/cliente/reserva.blade.php ENDPATH**/ ?>