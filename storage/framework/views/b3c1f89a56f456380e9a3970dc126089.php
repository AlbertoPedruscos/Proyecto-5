

<?php $__env->startSection('title', 'Inicio | MyControlPark'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/inicio.css')); ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div id="cont-general">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="/login" class="btn btn-primary btn-lg btn-block">Trabajador</a>
                </div>
                <div class="col">
                    <a href="/reserva" class="btn btn-secondary btn-lg btn-block">Cliente</a>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.plantilla_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Daw\m12\Proyecto-5\resources\views/inicio.blade.php ENDPATH**/ ?>