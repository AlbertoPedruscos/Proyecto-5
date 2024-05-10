@extends('layouts.plantilla_header')

@section('title', 'Inicio | MyControlPark')
@section('token')
    <meta name="csrf_token" content="{{ csrf_token() }}">
@endsection

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
            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
        </ul>
    </nav>

    <div id="formulario">
        <div id="cont-form">
            <h1>Haga su reserva</h1>
            <form action="" method="post" id="FrmReserva">
                <!-- Datos personales -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="nom_cliente" class="form-label">Nombre del cliente:</label>
                        <input type="text" class="form-control" id="nom_cliente" name="nom_cliente"
                            placeholder="Introduce tu nombre">
                    </div>
                    <div class="form-field">
                        <label for="num_telf" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="num_telf" name="num_telf"
                            placeholder="Introduce tu teléfono">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-field">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Introduce tu email">
                    </div>
                </div>

                <!-- Datos del coche -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="matricula" class="form-label">Matrícula:</label>
                        <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula">
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
                        <input type="text" class="form-control" id="color" name="color" placeholder="Color">
                    </div>
                </div>

                <!-- Detalles de la reserva -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="ubicacion_entrada" class="form-label">Punto de recogida:</label>
                        <select name="ubicacion_entrada" id="ubicacion_entrada">
                            <option value="Aeropuerto T1">Aeropuerto T1</option>
                            <option value="Aeropuerto T2">Aeropuerto T2</option>
                            <option value="Puerto">Puerto</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="ubicacion_salida" class="form-label">Punto de entrega:</label>
                        <select name="ubicacion_salida" id="ubicacion_salida">
                            <option value="Aeropuerto T1">Aeropuerto T1</option>
                            <option value="Aeropuerto T2">Aeropuerto T2</option>
                            <option value="Puerto">Puerto</option>
                        </select>
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
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function reservarNuevo() {
            var form = document.getElementById('FrmReserva');
            var formdata = new FormData(form);

            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/reservaO');

            ajax.onload = function() {
                if (ajax.status === 200) {
                    if (ajax.responseText === "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: '¡El vehiculo ha sido reservado!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        form.reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Hubo un problema al reservar el vehículo!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'asd',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            };

            ajax.send(formdata);
        }
    </script>
@endpush
