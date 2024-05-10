<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservas</title>
    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>

<body>
    <h3>Bienvenido</h3>
    <p>Aqui puedes realizar tu reserva</p>
    <form action="" method="post">
        <p>Nombre</p>
        <p><input type="text"></p>
        <p>Inicio</p>
        <input type="datetime-local" name="fechaini" id="">
        <p>Fin</p>
        <input type="datetime-local" name="fechafin" id="">
        <p><input type="submit" value="Reservar"></p>
    </form>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/vistas/reserva.blade.php ENDPATH**/ ?>