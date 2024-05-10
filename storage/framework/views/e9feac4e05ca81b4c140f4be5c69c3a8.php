<?php $__env->startSection('title', 'Mapa | MyControlPark'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/mapa_admin.css')); ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <header>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <img class="navbar-brand" src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo">
                <h4 class="text-white">Mapa (Admin)</h4>
                <a href="/" class="fa-solid fa-arrow-left text-white"></a>
            </div>
        </nav>
    </header>

    <div id="cont-principal">
        <div id="cont-crud" class="collapsed">
            <div class="menu-toggle" id="menuToggle">
                <span class="hamburger"></span>
                <span class="hamburger"></span>
                <span class="hamburger"></span>
            </div>

            <div class="menu-content">
                <h1>Listado de los Parkings:</h1>

                


                <!-- Manejo de errores y éxito -->
                <?php if(session('error')): ?>
                    <div class="alert alert-danger" style="padding-top: 10px"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="alert alert-success" style="padding-top: 10px"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <!-- Lista de parkings -->
                <div id="lista-parkings">
                    <?php $__currentLoopData = $parkings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="parking-item" id="parking-<?php echo e($parking->id); ?>">
                            <h3><?php echo e($parking->nombre); ?></h3> 
                            <?php if($parking->empresa): ?>
                                <p>Empresa: <?php echo e($parking->empresa->nombre); ?></p> 
                            <?php endif; ?>
                            <p>Latitud: <?php echo e($parking->latitud); ?></p>
                            <p>Longitud: <?php echo e($parking->longitud); ?></p>
                            <div>
                                <button class="btn btn-warning" onclick="editarParking(<?php echo e($parking->id); ?>)"
                                    data-bs-toggle="modal" data-bs-target="#modal-editar">Editar</button>

                                <!-- Agregar confirmación antes de eliminar -->
                                <form action="<?php echo e(route('parking.destroy', ['id' => $parking->id])); ?>" method="POST"
                                    onsubmit="return confirmDeletion()">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <input type="submit" class="btn btn-danger" value="Eliminar">
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div id="cont-mapa">
            

            <!-- Mapa con marcadores -->
            <div id="map" style="flex: 1; height: 100%;"></div>
        </div>
    </div>

    <!-- Modal para añadir parking -->
    <div class="modal fade" id="modal-crear" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal">Añadir Parking</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-crear-parking" action="<?php echo e(route('parking.post')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label para="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre...">
                        </div>

                        <div>
                            <label para="latitud">Latitud:</label>
                            <input type="text" name="latitud" id="latitud" placeholder="Latitud..." readonly>
                        </div>

                        <div>
                            <label para="longitud">Longitud:</label>
                            <input type="text" name="longitud" id="longitud" placeholder="Longitud..." readonly>
                        </div>

                        <div>
                            <label para="empresa">Empresa:</label>
                            <select name="empresa" id="empresa">
                                <option value="" disabled selected>-- Selecciona una opción --</option>
                                <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($empresa->id); ?>"><?php echo e($empresa->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div>
                            <input type="submit" name="btn-enviar" id="btn-enviar" value="Añadir">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar parking -->
    <div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="modal-editar"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Parking</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editar-parking" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="id" id="editar-id">

                        <div>
                            <label para="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="editar-nombre">
                        </div>

                        <div>
                            <label para="latitud">Latitud:</label>
                            <input type="text" name="latitud" id="editar-latitud" readonly>
                        </div>

                        <div>
                            <label para="longitud">Longitud:</label>
                            <input type="text" name="longitud" id="editar-longitud" readonly>
                        </div>

                        <div>
                            <label para="empresa">Empresa:</label>
                            <select name="empresa" id="editar-empresa">
                                <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($empresa->id); ?>"><?php echo e($empresa->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div>
                            <input type="submit" name="btn-editar" value="Guardar Cambios">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://unpkg.com/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Configurar el mapa
        var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Evento de clic en el mapa para abrir el modal de añadir parking
        map.on('click', function(e) {
            var latlng = e.latlng; // Obtiene las coordenadas del punto clicado

            // Cargar las coordenadas en el formulario del modal para añadir parking
            $("#latitud").val(latlng.lat); // Asigna la latitud al campo correspondiente
            $("#longitud").val(latlng.lng); // Asigna la longitud al campo correspondiente

            // Mostrar el modal para añadir un nuevo parking
            $("#modal-crear").modal("show");
        });

        // Definir el icono para la ubicación del usuario
        var userIcon = L.divIcon({
            className: 'custom-user-icon',
            html: '<i class="fa-solid fa-person" style="font-size: 1.5rem;"></i>',
            iconSize: [30, 42], // Tamaño del icono
            iconAnchor: [15, 42], // Punto de anclaje para el icono
        });

        // Añadir un marcador de ejemplo para la ubicación especificada
        L.marker([41.34982299030039, 2.1076393201706303], {
            icon: userIcon
        }).addTo(map);

        // Marcar todos los parkings existentes
        var parkingIcon = L.divIcon({
            className: 'custom-parking-icon',
            html: '<i class="fas fa-parking" style="font-size: 1.5rem; color: blue;"></i>',
            iconSize: [30, 42], // Tamaño del icono
            iconAnchor: [15, 42], // Punto de anclaje para el icono
        });

        <?php $__currentLoopData = $parkings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            L.marker([<?php echo e($parking->latitud); ?>, <?php echo e($parking->longitud); ?>], {
                    icon: parkingIcon
                })
                .bindPopup(
                    '<b><?php echo e($parking->nombre); ?></b><br>Lat: <?php echo e($parking->latitud); ?>, \nLon: <?php echo e($parking->longitud); ?>'
                )
                .addTo(map);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        function confirmDeletion() {
            return confirm("¿Estás seguro de que quieres eliminar este parking?");
        }

        // Función para cargar datos y mostrar el modal de edición
        function editarParking(id) {
            $.ajax({
                url: "/parking/" + id,
                type: 'GET',
                success: function(parking) {
                    // Cargar datos del parking en el formulario
                    $("#editar-id").val(parking.id); // Guardar el ID del parking
                    $("#editar-nombre").val(parking.nombre);
                    $("#editar-latitud").val(parking.latitud);
                    $("#editar-longitud").val(parking.longitud);
                    $("#editar-empresa").val(parking.id_empresa);

                    // Actualizar la acción del formulario para la edición
                    $("#formulario-editar-parking").attr("action", "/parking/" + parking.id);

                    // Mostrar el modal de edición
                    $("#modal-editar").modal("show");
                },
                error: function() {
                    alert("Error al obtener los datos del parking.");
                }
            });
        }

        // Alternar entre expandir y contraer el panel lateral
        document.getElementById('menuToggle').addEventListener('click', function() {
            var contCrud = document.getElementById('cont-crud');
            contCrud.classList.toggle('expanded');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.plantilla_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DAW\M12\Proyecto-5\resources\views/vistas/mapa_admin.blade.php ENDPATH**/ ?>