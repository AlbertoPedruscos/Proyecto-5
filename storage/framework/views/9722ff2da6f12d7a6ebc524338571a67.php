<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la reserva #<?php echo e($reserva_cliente->id); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('./css/info_reserva.css')); ?>">
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Reserva núm. #<?php echo e($reserva_cliente->id); ?></a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <a class="navbar-brand" href="logout" class="dropdown-item" style="color: black;">Cerrar sesión</a>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="reserva">
        <div class="info">
            <p class="d-inline-flex gap-1">
                <a class="btn btn-dark" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <?php echo e($reserva_cliente->matricula); ?>

                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?php echo e($reserva_cliente->nom_cliente); ?></li>
                        <li class="list-group-item"><?php echo e($reserva_cliente->marca); ?> <?php echo e($reserva_cliente->modelo); ?></li>
                        <li class="list-group-item"><?php echo e($reserva_cliente->num_telf); ?></li>
                        <li class="list-group-item"><?php echo e($reserva_cliente->email); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="registros">
            <div class="entrada">
                <div class="reg_entr">
                    <p>Registro de entrada</p>
                    <p><?php echo e($reserva_cliente->fecha_entrada); ?></p>
                    <p><?php echo e($reserva_cliente->ubicacion_entrada); ?></p>
                </div>
                <div class="check_entr" onclick="window.location.href = '/cambio'">
                    <?php if($reserva_cliente->firma_entrada === null): ?>
                        <span class="material-symbols-outlined"> 
                        check_circle
                        </span>
                    <?php else: ?> 
                    <span class="material-symbols-outlined">
                        done
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="salida">
                <div class="reg_sal">
                    <p>Registro de salida</p>
                    <p><?php echo e($reserva_cliente->fecha_salida); ?></p>
                    <p><?php echo e($reserva_cliente->ubicacion_salida); ?></p>
                </div>
                <div class="check_sal">
                    <?php if($reserva_cliente->firma_salida === null): ?>
                        <span class="material-symbols-outlined">
                            door_open
                        </span>
                    <?php else: ?> 
                        <span class="material-symbols-outlined">
                            door_back
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="imagenes">
            <input type="file" capture="camera">
            <input type="file" accept="image/*" capture="camera">
        </div>
        <div class="desplazamientos">

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Daw\m12\Proyecto-5\resources\views/reserva_cliente.blade.php ENDPATH**/ ?>