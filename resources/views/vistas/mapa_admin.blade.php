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

                <button type="button" class="fa-solid fa-plus" data-bs-toggle="modal" data-bs-target="#modal"
                    id="icono-suma" style="color: green; border: 2px solid green; padding: 5px;"></button>

                <div id="resultado"></div>
            </div>
        </div>
        
        <div id="cont-mapa">
            <form action="">
                <label for="punto">Punto</label>
                <input type="text" id="punto" name="punto" placeholder="Busca un punto">
            </form>

            <div id="map" style="flex: 1; height: 100%;"></div>
        </div>
    </div>

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
                    <form>
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
                            <label para="empresa">Empresa</label>
                            <section>
                                <select name="empresa" id="empresa">
                                    <option value="" selected disabled>-- Selecciona una opción --</option>
                                    <option value="empresa1">Empresa 1</option>
                                    <option value="empresa2">Empresa 2</option>
                                    <option value="empresa3">Empresa 3</option>
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
        var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([41.34971957556145, 2.1076759794296467]).addTo(map);

        map.on('click', function(e) {
            var latlng = e.latlng;
            L.popup()
                .setLatLng(latlng)
                .setContent("Latitud: " + latlng.lat + " Longitud: " + latlng.lng)
                .openOn(map);
        });

        document.getElementById('menuToggle').addEventListener('click', function() {
            var contCrud = document.getElementById('cont-crud');
            contCrud.classList.toggle('expanded'); // Alternar entre colapsado y expandido
        });
    </script>
@endpush
