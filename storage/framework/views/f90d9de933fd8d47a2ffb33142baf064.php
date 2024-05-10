
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $__env->yieldContent('title', 'MyControlPark'); ?></title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
        <!-- CSS personalizado -->
        <?php echo $__env->yieldContent('css'); ?>
        <!-- Icono -->
        <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>">
        
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    </head>

    <body>
        <?php echo $__env->yieldContent('content'); ?> <!-- Sección para el contenido -->
    </body>

    </html>

<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/layouts/plantilla_header.blade.php ENDPATH**/ ?>