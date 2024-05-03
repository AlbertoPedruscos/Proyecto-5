@extends('layouts.plantilla_header')

@section('title', 'Mapa | MyControlPark')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mapa_admin.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Para iconos -->
@endsection

@section('content')
    <header>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <img class="navbar-brand" src="{{ asset('img/logo.png') }}" alt="Logo">
                <h4 class="text-white">Mapa (Admin)</h4>
                <a href="" class="fa-solid fa-arrow-left text-white"></a>
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

                <!-- Botón para abrir modal de añadir parking -->
                <button type="button" class="fa-solid fa-plus" data-bs-toggle="modal" data-bs-target="#modal-crear"
                    id="icono-suma" style="color: green; border: 2px solid green; padding: 5px;"></button>

                <!-- Lista de parkings -->
                <div id="lista-parkings">
                    @foreach ($parkings as $parking)
                        <div class="parking-item" id="parking-{{ $parking->id }}">
                            <h3>{{ $parking->nombre }}</h3>
                            <p>Latitud: {{ $parking->latitud }}, <br> Longitud: {{ $parking->longitud }}</p>
                            <button class="btn btn-warning" onclick="editarParking({{ $parking->id }})"
                                data-bs-toggle="modal" data-bs-target="#modal-editar">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarParking({{ $parking->id }})">Eliminar</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="cont-mapa">
            <form action="">
                <label for="punto">Punto</label>
                <input type="text" id="punto" name="punto" placeholder="Busca un punto">
            </form>

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
                    <form id="formulario-crear-parking">
                        <div>
                            <label para="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre">
                        </div>

                        <div>
                            <label para="latitud">Latitud:</label>
                            <input type="text" name="latitud" id="latitud">
                        </div>

                        <div>
                            <label para="longitud">Longitud:</label>
                            <input type="text" name="longitud" id="longitud">
                        </div>

                        <div>
                            <label para="empresa">Empresa:</label>
                            <select name="empresa" id="empresa">
                                @foreach ($empresas as $empresa)
                                    <option value="" disabled selected>-- Selecciona una opción --</option>
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                @endforeach
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
                    <form id="formulario-editar-parking">
                        <div>
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="editar-nombre">
                        </div>

                        <div>
                            <label para="latitud">Latitud:</label>
                            <input type="text" name="latitud" id="editar-latitud">
                        </div>

                        <div>
                            <label para="longitud">Longitud:</label>
                            <input type="text" name="longitud" id="editar-longitud">
                        </div>

                        <div>
                            <label para="empresa">Empresa:</label>
                            <select name="empresa" id="editar-empresa">
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <input type="submit" name="btn-editar" id="btn-editar" value="Guardar Cambios">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Configurar el mapa
        var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Definir el icono para la ubicación del usuario
        var userIcon = L.divIcon({
            className: 'custom-user-icon',
            html: '<i class="fa-solid fa-person" style="font-size: 1.5rem; color: red;"></i>',
            iconSize: [30, 42], // Tamaño del icono
            iconAnchor: [15, 42], // Punto de anclaje para el icono
        });

        // Añadir el marcador en la ubicación especificada
        L.marker([41.34982299030039, 2.1076393201706303], {
                icon: userIcon
            }).addTo(map)
            .bindPopup("Ubicación del usuario")
            .openPopup(); // Abre el popup cuando se carga el mapa
        // Marcar todos los parkings
        var parkingIcon = L.divIcon({
            className: 'custom-parking-icon',
            html: '<i class="fas fa-parking" style="font-size: 1.5rem; color: blue;"></i>',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
        });

        @foreach ($parkings as $parking)
            L.marker([{{ $parking->latitud }}, {{ $parking->longitud }}], {
                    icon: parkingIcon
                })
                .bindPopup(
                    '<b>{{ $parking->nombre }}</b><br>Lat: {{ $parking->latitud }}, Lon: {{ $parking->longitud }}')
                .addTo(map);
        @endforeach

        // Función para editar parking y abrir el modal
        function editarParking(id) {
            // Se hace una solicitud AJAX para obtener la información del parking por su ID
            $.ajax({
                url: "/parking/" + id,
                type: 'GET',
                success: function(parking) {
                    // Si la solicitud es exitosa, llenamos el formulario con los datos del parking
                    $("#editar-nombre").val(parking.nombre);
                    $("#editar-latitud").val(parking.latitud);
                    $("#editar-longitud").val(parking.longitud);
                    $("#editar-empresa").val(parking.empresa_id);

                    // Abrir el modal de edición
                    $("#modal-editar").modal("show");
                },
                error: function() {
                    // Mostrar un mensaje de error si la solicitud falla
                    alert("Error al obtener los datos del parking. Por favor, intenta nuevamente.");
                }
            });
        }

        // Función para eliminar un parking
        function eliminarParking(id) {
            if (confirm("¿Estás seguro de que deseas eliminar el parking con ID: " + id + "?")) {
                $.ajax({
                    url: "/parking/" + id,
                    type: 'DELETE',
                    success: function(data) {
                        if (data.success) {
                            // Eliminar el elemento del DOM
                            $("#parking-" + id).remove();
                            alert("Parking eliminado con éxito.");
                        } else {
                            alert("Error al eliminar el parking.");
                        }
                    },
                    error: function() {
                        alert("Error al eliminar el parking.");
                    }
                });
            }
        }

        // Alternar cont-crud expandir/contraer
        document.getElementById('menuToggle').addEventListener('click', function() {
            var contCrud = document.getElementById('cont-crud');
            contCrud.classList.toggle('expanded');
        });
    </script>
@endpush
