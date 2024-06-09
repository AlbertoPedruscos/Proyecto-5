@extends('layouts.plantilla_header')

@section('title', 'Ubicaciones | MyControlPark')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
@endsection

@if (session('id'))
    @section('content')
        {{-- NAVBAR --}}
        <header>
            <nav>
                <ul class="nav-left">
                    <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                    <li><a href="{{ route('gestEmpleados') }}" style="text-decoration: none;">Empleados</a></li>
                    <li><a href="{{ 'reservas' }}" style="text-decoration: none;">Reservas</a></li>
                    <li><a href="{{ 'mapa' }}" style="text-decoration: none;">Mapa</a></li>
                    <li><a href="{{ 'historial' }}" style="text-decoration: none;">Historial de actividad de los
                            aparcacoches</a></li>
                    <li class="active">Crear ubicaciones</li>
                </ul>

                <ul class="nav-right">
                    <li>{{ session('nombre') }}</li>

                    @if (session('nombre_empresa'))
                        <li>{{ session('nombre_empresa') }}</li>
                    @else
                        <li>Empresa no asignada</li>
                    @endif

                    <li><a href="{{ route('logout') }}">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>

        {{-- BOTONES --}}
        <div id="cont_botones">
            {{-- REGISTRAR USUARIO --}}
            <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#registerModal"
                onclick="abrirModal()">Añadir
                ubicación</button>

            {{-- BOTÓN PARA VOLVER A LA PÁGINA PRINCIPAL POR DEFECTO --}}
            <button type="button" class="btn btn-dark" style="border-radius: 5px;">
                <a href="{{ route('ubicaciones') }}" style="text-decoration: none; color: white;">Quitar filtros</a>
            </button>

            <button type="button" class="btn btn-secondary" style="border-radius: 5px;">
                <a href="{{ route('ubicaciones.exportar.csv') }}" style="text-decoration: none; color: white;">Exportar
                    CSV</a>
            </button>
        </div>

        <div id="cont_alertas">
            @if (session('error'))
                <div class="alert alert-danger" style="padding-top: 10px">{{ session('error') }}</div>
            @endif

            {{-- MENSAJE ÉXITO --}}
            @if (session('success'))
                <div class="alert alert-success" style="padding-top: 10px">{{ session('success') }}</div>
            @endif
        </div>

        {{-- TABLA --}}
        <div id="tabla">
            @include('tablas.tbl_ubicaciones')
        </div>

        {{-- MODAL AÑADIR UBICACIÓN --}}
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-lg-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModal">Añadir Ubicación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('ubicaciones.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nombre_sitio">Nombre del sitio:</label>
                                <input type="text" id="nombre_sitio" name="nombre_sitio" class="form-control"
                                    placeholder="Introduce el nombre">
                            </div>
                            <div class="form-group">
                                <label for="calle">Calle:</label>
                                <input type="text" id="calle" name="calle" class="form-control" readonly
                                    placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="ciudad">Ciudad:</label>
                                <input type="text" id="ciudad" name="ciudad" class="form-control" readonly
                                    placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="latitud">Latitud:</label>
                                <input type="text" id="latitud" name="latitud" class="form-control" readonly
                                    placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="longitud">Longitud:</label>
                                <input type="text" id="longitud" name="longitud" class="form-control" readonly
                                    placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa"
                                    readonly>
                            </div>
                            <input type="hidden" name="fecha_creacion" id="fecha_creacion">
                            <button type="button" class="btn btn-outline-success" onclick="abrirMapa()"><i
                                    class="fa-solid fa-location-dot"></i></button>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary mt-2">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL MAPA --}}
        <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mapModalLabel">Seleccionar ubicación en el mapa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @php
        header('Location: ' . route('login'));
        exit();
    @endphp
@endif

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7+Yj7/6/gqH1D00iW6c+zo5FJ3w7QaXK/z6ZC9Yg" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"
        integrity="sha384-B4tt8/DBP0LbRULaFO15QwEReKo0+kTPrUN6RfFzAD5SMoFfO+Xt5Jx5W2c6Xg7L" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9b4Is3NZoJ6wTrFjjGmkjFw8LLAPk2vRT0TctW7NO3S1Zef6j5oaJXp" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        function abrirModal() {
            $('#registerModal').modal('show');
        }

        function abrirMapa() {
            $('#mapModal').modal('show');
            setTimeout(() => {
                map.invalidateSize();
            }, 400); // Ensure the map is fully rendered after modal opens
        }

        var map = L.map('map').setView([40.4168, -3.7038], 15); // Coordenadas de España centradas en Madrid

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        var geocoder = L.Control.Geocoder.nominatim();

        map.on('click', function(e) {
            var latlng = e.latlng;
            document.getElementById('latitud').value = latlng.lat;
            document.getElementById('longitud').value = latlng.lng;
            document.getElementById('fecha_creacion').value = new Date().toISOString();

            console.log('Latitud:', latlng.lat);
            console.log('Longitud:', latlng.lng);

            geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function(results) {
                var r = results[0];
                if (r) {
                    var address = r.properties.address;
                    var city = address.city || address.town || address.village || '';
                    var street = address.road || '';

                    document.getElementById('ciudad').value = city;
                    document.getElementById('calle').value = street;

                    console.log('Ciudad:', city);
                    console.log('Calle:', street);
                }
            });

            $('#mapModal').modal('hide');
        });
    </script>
@endpush
