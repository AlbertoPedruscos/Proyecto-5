@extends('layouts.plantilla_header')

@section('title', 'Mapa | MyControlPark')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mapa_admin.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
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
                <button type="button" class="fa-solid fa-plus" data-bs-toggle="modal" data-bs-target="#modal"
                    id="icono-suma" style="color: green; border: 2px solid green; padding: 5px;"></button>

                <!-- Lista de parkings -->
                <div id="lista-parkings">
                    @foreach ($parkings as $parking)
                        <div class="parking-item">
                            <h3>{{ $parking->nombre }}</h3>
                            <p>Latitud: {{ $parking->latitud }}, Longitud: {{ $parking->longitud }}</p>
                            <button class="btn btn-primary" onclick="mostrarParking({{ $parking->id }})">Mostrar</button>
                            <button class="btn btn-warning" onclick="editarParking({{ $parking->id }})">Editar</button>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
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
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre del parking">
                        </div>

                        <div>
                            <label para="latitud">Latitud:</label>
                            <input type="text" name="latitud" id="latitud" placeholder="Latitud del parking">
                        </div>

                        <div>
                            <label para="longitud">Longitud:</label>
                            <input type="text" name="longitud" id="longitud" placeholder="Longitud del parking">
                        </div>

                        <div>
                            <label for="empresa">Empresa</label>
                            <section>
                                <select name="empresa" id="empresa">
                                    <option value="" selected disabled>-- Selecciona una empresa --</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </section>
                        </div>

                        <div>
                            <input type="submit" name="btn-enviar" id="btn-enviar" value="Añadir">
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

    <script>
        // Configurar el mapa
        var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Crear un marcador personalizado para parkings
        var parkingIcon = L.divIcon({
            className: 'custom-parking-icon',
            html: '<i class="fas fa-parking" style="font-size: 1.5rem; color: blue;"></i>',
            iconSize: [30, 42], // Ajusta el tamaño del marcador
            iconAnchor: [15, 42], // Ajusta el anclaje del marcador
        });

        // Crear un marcador personalizado para la ubicación del usuario
        var userIcon = L.divIcon({
            className: 'custom-user-icon',
            html: '<i class="fa-solid fa-person" style="font-size: 1.5rem; color: red;"></i>',
            iconSize: [30, 42], // Ajusta el tamaño del marcador
            iconAnchor: [15, 42], // Ajusta el anclaje del marcador
        });

        // Añadir marcadores para cada parking
        @foreach ($parkings as $parking)
            L.marker([{{ $parking->latitud }}, {{ $parking->longitud }}], {
                    icon: parkingIcon
                }).addTo(map)
                .bindPopup(
                    '<b>{{ $parking->nombre }}</b><br>Lat: {{ $parking->latitud }}, Lon: {{ $parking->longitud }}');
        @endforeach

        // Obtener la ubicación actual del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    // Agregar un marcador para la ubicación actual
                    L.marker([lat, lng], {
                            icon: userIcon
                        }).addTo(map)
                        .bindPopup("Ubicación actual del usuario")
                        .openPopup(); // Abre un pop-up al cargar

                    // Centrar el mapa en la ubicación del usuario
                    map.setView([lat, lng], 18);
                },
                function(error) {
                    console.error("Error al obtener la ubicación del usuario: " + error.message);
                }, {
                    enableHighAccuracy: true, // Utilizar alta precisión
                    timeout: 10000, // Tiempo máximo para obtener la ubicación
                    maximumAge: 0 // No utilizar datos antiguos
                }
            );
        } else {
            console.warn("La geolocalización no es compatible con este navegador.");
        }

        // Manejo de eventos del mapa
        map.on('click', function(e) {
            var latlng = e.latlng;
            L.popup()
                .setLatLng(latlng)
                .setContent("Latitud: " + latlng.lat + "<br>Longitud: " + latlng.lng)
                .openOn(map);
        });

        // Funciones para mostrar, editar y eliminar parkings
        function mostrarParking(id) {
            alert("Mostrar información del parking con ID: " + id);
        }

        function editarParking(id) {
            alert("Editar información del parking con ID: " + id);
        }

        function eliminarParking(id) {
            if (confirm("¿Estás seguro de que deseas eliminar el parking con ID: " + id + "?")) {
                alert("Eliminar parking con ID: " + id);
            }
        }

        // Alternar cont-crud expandir/contraer
        document.getElementById('menuToggle').addEventListener('click', function() {
            var contCrud = document.getElementById('cont-crud');
            contCrud.classList.toggle('expanded');
        });
    </script>
@endpush
