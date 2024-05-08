@extends('layouts.plantilla_header')

@section('title', 'Inicio | MyControlPark')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
    <nav>
        <ul class="nav-left">
            <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
        </ul>

        <ul class="nav-right">
            <li><a href="">Sobre nosotros</a></li>
            <li><a href="">Contáctanos</a></li>
            <li><a href="">Iniciar sesión</a></li>
        </ul>
    </nav>

    <div id="formulario">
        <div id="cont-form">
            <h1>Haga su reserva:</h1>

            <!-- Datos personales -->
            <div class="form-group">
                <div class="form-field">
                    <label for="nom_cliente" class="form-label">Nombre del cliente:</label>
                    <input type="text" class="form-control" id="nom_cliente" name="nom_cliente" placeholder="Introduce tu nombre">
                </div>
                <div class="form-field">
                    <label for="num_telf" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="num_telf" name="num_telf" placeholder="Introduce tu teléfono">
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu email">
                </div>
            </div>

            <!-- Datos del coche -->
            <div class="form-group">
                <div class="form-field">
                    <label for="matricula" class="form-label">Matrícula:</label>
                    <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matricula">
                </div>
                <div class="form-field">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca">
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo">
                </div>
                <div class="form-field">
                    <label for="color" class="form-label">Color:</label>
                    <input type="text" class="form-control" id="color" name="color" placeholder="color">
                </div>
            </div>

            <!-- Detalles de la reserva -->
            <div class="form-group">
                <div class="form-field">
                    <label for="ubicacion_entrada" class="form-label">Punto de recogida:</label>
                    <input type="text" class="form-control" id="ubicacion_entrada" name="ubicacion_entrada" placeholder="Ej. Centric - El Prat">
                </div>
                <div class="form-field">
                    <label for="ubicacion_salida" class="form-label">Punto de entrega:</label>
                    <input type="text" class="form-control" id="ubicacion_salida" name="ubicacion_salida"placeholder="Ej. Centric - El Prat">
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="fecha_entrada" class="form-label">Fecha de Entrada:</label>
                    <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada">
                </div>
                <div class="form-field">
                    <label for="fecha_salida" class="form-label">Fecha de Salida:</label>
                    <input type="datetime-local" class="form-control" id="fecha_salida" name="fecha_salida">
                </div>
            </div>

            <div>
                <button type="button" onclick="reservarNuevo()">Enviar</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
