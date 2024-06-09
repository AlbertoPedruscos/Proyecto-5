@extends('layouts.plantilla_header')

@section('title', 'Empleados | MyControlPark')

@section('token')
    <meta name="csrf_token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@if (session('id'))
    @section('content')
        {{-- NAVBAR --}}
        <header>
            <nav>
                <ul class="nav-left">
                    <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                    <li class="active">Empleados</li>
                    <li><a href="{{ 'reservas' }}" style="">Reservas</a></li>
                    <li><a href="{{ 'mapa' }}">Mapa</a></li>
                    <li><a href="{{ 'historial' }}">Historial de actividad de los aparcacoches</a></li>
                    <li><a href="{{ 'ubicaciones' }}">Crear ubicaciones</a></li>
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
            <button type="button" class="btn btn-outline-dark" id="abrirModal">Añadir usuario</button>

            {{-- BOTÓN PARA VOLVER A LA PÁGINA PRINCIPAL POR DEFECTO --}}
            <button type="button" class="btn btn-dark" style="border-radius: 5px;">
                <a href="{{ 'gestEmpleados' }}" style="text-decoration: none; color: white;">Quitar filtros</a>
            </button>

            {{-- EXPORTAR CSV --}}
            <button type="button" class="btn btn-secondary" id="exportarCSV">
                <a href="{{ route('empleados.exportarCSV') }}" style="text-decoration: none; color: white;">Exportar a CSV</a>
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
            @include('tablas.tbl_empleados')
        </div>

        {{-- MODAL AÑADIR USUARIO --}}
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-lg-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Registrar empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('empleado.store') }}" method="post" id="frmRegistro">
                            @csrf

                            <input type="hidden" name="currentUrl" id="currentUrl">

                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre"
                                    class="form-control" value="{{ isset($empleado) ? $empleado->nombre : '' }}">
                                <div class="error-mensaje" style="color: red;"></div>
                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellidos:</label>
                                <input type="text" name="apellido" id="apellido" placeholder="Introduce el apellido"
                                    class="form-control" value="{{ isset($empleado) ? $empleado->apellidos : '' }}">
                                <div class="error-mensaje" style="color: red;"></div>
                            </div>

                            <button type="submit" class="btn btn-outline-dark">Registrar</button>
                        </form>
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
    <script src="{{ asset('js/empleados.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            function fetchData(page) {
                $.ajax({
                    url: "?page=" + page,
                    method: "GET",
                    data: $('#filterForm').serialize(),
                    success: function(data) {
                        $('#tabla').html(data);
                    }
                });
            }

            $(document).on('submit', '#filterForm', function(e) {
                e.preventDefault();
                fetchData(1);
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchData(page);
            });

            $('#perPage').on('change', function() {
                $('#filterForm').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#orderField, #orderDirection').on('change', function() {
                fetchData(1); // Llamar a la función fetchData con la página 1 cuando cambie el ordenamiento
            });

            function fetchData(page) {
                var orderField = $('#orderField').val();
                var orderDirection = $('#orderDirection').val();

                $.ajax({
                    url: "{{ route('gestEmpleados') }}?page=" + page,
                    method: "GET",
                    data: $('#filterForm').serialize() + "&orderField=" + orderField + "&orderDirection=" +
                        orderDirection,
                    success: function(data) {
                        $('#tabla').html(data);
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener los formularios de registro y edición
            var formRegistro = document.getElementById('frmRegistro');
            var formEdicion = document.getElementById('frmEdicion'); // Cambia este ID según corresponda

            // Función para validar en tiempo real
            function validarCampo(event) {
                var campo = event.target;
                var valor = campo.value.trim();
                var regexNumeros = /\d/;
                var mensajeError = '';

                if (regexNumeros.test(valor)) {
                    mensajeError = 'El campo no puede contener números.';
                } else if (valor !== campo.value) {
                    mensajeError = 'El campo no debe contener espacios al inicio o al final.';
                }

                var mensajeErrorElemento = campo.nextElementSibling;
                if (mensajeErrorElemento && mensajeErrorElemento.classList.contains('error-mensaje')) {
                    mensajeErrorElemento.textContent = mensajeError;
                } else {
                    mensajeErrorElemento = document.createElement('div');
                    mensajeErrorElemento.className = 'error-mensaje';
                    mensajeErrorElemento.textContent = mensajeError;
                    campo.parentNode.insertBefore(mensajeErrorElemento, campo.nextSibling);
                }
            }

            // Asignar la función de validación en tiempo real a los eventos keyup y blur
            var camposValidar = ['nombre', 'apellido'];
            camposValidar.forEach(function(campo) {
                var campoElemento = document.getElementById(campo);
                if (campoElemento) {
                    campoElemento.addEventListener('keyup', validarCampo);
                    campoElemento.addEventListener('blur', validarCampo);
                }
            });

            // Función para validar el formulario en el evento submit
            function validarFormulario(event) {
                var nombre = document.getElementById('nombre').value.trim();
                var apellido = document.getElementById('apellido').value.trim();
                var regexNumeros = /\d/;
                var esValido = true;

                if (regexNumeros.test(nombre) || nombre !== document.getElementById('nombre').value) {
                    esValido = false;
                    validarCampo({
                        target: document.getElementById('nombre')
                    });
                }

                if (regexNumeros.test(apellido) || apellido !== document.getElementById('apellido').value) {
                    esValido = false;
                    validarCampo({
                        target: document.getElementById('apellido')
                    });
                }

                if (!esValido) {
                    event.preventDefault();
                }
            }

            // Asignar la función de validación al evento submit del formulario de registro
            if (formRegistro) {
                formRegistro.addEventListener('submit', validarFormulario);
            }

            // Asignar la función de validación al evento submit del formulario de edición
            if (formEdicion) {
                formEdicion.addEventListener('submit', validarFormulario);
            }
        }); 
        
    </script> --}}
    <script>
        // Definición de la función eliminarUsuario
        function eliminarUsuario(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                position: 'top-end',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('frmEliminar' + id).submit();
                }
            });
        }
    </script>
@endpush
