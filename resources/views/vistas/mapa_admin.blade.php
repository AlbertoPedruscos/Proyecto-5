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
            <h1 style="color: white">Parkings</h1>
        </div>
        <div id="map" style="flex: 1; height: 100%;"> 
        </div>
    </div>
@endsection

@push('scripts') 
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> <!-- Script de Leaflet -->

    <script>
        // Inicializar el mapa con coordenadas iniciales
        var map = L.map('map').setView([51.505, 0.09], 13);

        // Añadir la capa de OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Añadir un marcador para probar el mapa
        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('Un popup de ejemplo.<br> Fácil de personalizar.')
            .openPopup(); // Abre el popup por defecto
    </script>
@endpush
