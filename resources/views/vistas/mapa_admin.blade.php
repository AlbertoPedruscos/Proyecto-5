@extends('layouts.plantilla_header') <!-- Extiende desde la plantilla base -->

@section('title', 'Mapa | MyControlPark') <!-- Título personalizado -->

@section('css') <!-- CSS adicional -->
    <link rel="stylesheet" href="{{ asset('css/mapa_admin.css') }}"> <!-- CSS personalizado -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"> <!-- CSS para Leaflet -->
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

    <!-- Contenedor principal con Flexbox -->
    <div id="cont-principal">
        <div id="cont-crud">
            <h1 style="color: white; text-align: center; font-size: 35px; font-family:Helvetica; padding: 25px 0px;">Listado
                de los Parkings</h1>

            <div>
                <h3>Añadir parking</h3>
                <form action="">
                    <div>
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre del parking">
                    </div>

                    <div>
                        <label para="latitud">Latitud</label>
                        <input type="text" name="latitud" id="latitud" placeholder="Latitud del parking">
                    </div>

                    <div>
                        <label para="longitud">Longitud</label>
                        <input type="text" name="longitud" id="longitud" placeholder="Longitud del parking">
                    </div>

                    <div>
                        <label para="empresa">Empresa</label>
                        <input type="empresa" name="empresa" id="empresa" placeholder="Empresa del parking">
                    </div>

                    <div>
                        <input type="submit" name="btn-enviar" id="btn-enviar" value="Añadir">
                    </div>
                </form>
            </div>
        </div>
        <div id="map" style="flex: 1; height: 100%;">
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> <!-- Script de Leaflet -->

    <script>
        // Inicializar el mapa con coordenadas especificadas
        var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

        // Añadir la capa de OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Añadir un marcador con las coordenadas especificadas
        L.marker([41.34971957556145, 2.1076759794296467]).addTo(map)

        // Función para mostrar un popup al hacer clic en el mapa
        map.on('click', function(e) {
            var latlng = e.latlng; // Coordenadas del clic
            L.popup()
                .setLatLng(latlng) // Posición del popup
                .setContent("Coordenadas: " + latlng.lat + ", " + latlng.lng) // Contenido del popup
                .openOn(map); // Mostrar el popup
        });
    </script>
@endpush
