<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalles de la Reserva</title>
</head>

<body>
    <h1>Hola <?php echo e($reserva->nom_cliente); ?> Esta es tu reserva</h1>
    
    <p><strong>Categoría:</strong> <?php echo e($reserva->fecha_inicio); ?></p>
    <p><strong>Descripción:</strong> <?php echo e($reserva->fecha_fin); ?></p>
    <p><strong>Firma:</strong> <?php echo e($reserva->firma); ?></p>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/cliente/detalles.blade.php ENDPATH**/ ?>