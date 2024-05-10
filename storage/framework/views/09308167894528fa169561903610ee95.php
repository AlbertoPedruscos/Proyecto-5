<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobar reserva</title>
    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>">
</head>

<body>
    <p><a href="<?php echo e(route('cliente.frmreserva')); ?>">Hacer una reserva</a></p>
    <form action="" method="post">
        <p>Codigo</p>
        <input type="text">
        <p><input type="submit" value="Comprobar"></p>
    </form>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/cliente/comprobar.blade.php ENDPATH**/ ?>