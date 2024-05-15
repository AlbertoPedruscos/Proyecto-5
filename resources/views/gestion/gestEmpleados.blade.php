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
                    <li><a href="{{ 'reservas' }}">Reservas</a></li>
                    <li><a href="{{ 'mapa' }}">Mapa</a></li>
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

        {{-- MENSAJE ERROR --}}
        @if (session('error'))
            <div class="alert alert-danger" style="padding-top: 10px">{{ session('error') }}</div>
        @endif

        {{-- MENSAJE ÉXITO --}}
        @if (session('success'))
            <div class="alert alert-success" style="padding-top: 10px">{{ session('success') }}</div>
        @endif

        {{-- CANTIDAD DE USUARIOS --}}
        <h3>Total de usuarios: ({{ count($empleados) }})</h3>

        {{-- FILTRO POR TEXTO --}}
        <form id="searchForm" method="GET">
            <div class="form-group">
                <label for="search">Buscar por nombre:</label>
                <input type="text" name="search" id="search" class="form-control"
                    value="{{ request()->input('search') }}" onkeyup="buscarEmpleado()"
                    placeholder="Busca por nombre de empleado">
            </div>
        </form>

        {{-- FILTRO POR ROL --}}
        <form action="">
            <select name="rol" id="rol" onchange="buscarEmpleado()">
                <option value="" selected disabled>-- Selecciona un rol --</option>
                @foreach ($roles as $rol)
                    @if ($rol->id != 1)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endif
                @endforeach
            </select>
        </form>

        {{-- REGISTRAR USUARIO --}}
        <button type="button" class="btn btn-primary" id="abrirModal">Registrar usuario</button>

        {{-- TABLA --}}
        <div id="tabla">
            @include('tablas.tbl_empleados')
        </div>

        {{-- MODAL AÑADIR USUARIO --}}
        <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modallogin">Registrar usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('empleado.store') }}" method="post" id="frmlogin">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellidos:</label>
                                <input type="text" name="apellido" id="apellido" placeholder="Introduce el apellido"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" placeholder="Introduce el email"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="pass">Contraseña:</label>
                                <input type="password" name="pass" id="pass" placeholder="Introduce la contraseña"
                                    class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDITAR USUARIO --}}
        <!-- Agrega esto al final de tu vista -->
        <div id="editarEmpleadoModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Empleado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editarEmpleadoForm">
                            @csrf
                            <input type="hidden" id="editEmpleadoId" name="editEmpleadoId">
                            <div class="form-group">
                                <label for="editNombre">Nombre:</label>
                                <input type="text" class="form-control" id="editNombre" name="editNombre">
                            </div>
                            <div class="form-group">
                                <label for="editApellido">Apellido:</label>
                                <input type="text" class="form-control" id="editApellido" name="editApellido">
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email:</label>
                                <input type="email" class="form-control" id="editEmail" name="editEmail">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        {{-- MOSTRAR MODAL AGREGAR USUARIO --}}
        <script>
            $(document).ready(function() {
                $('#abrirModal').click(function() {
                    $('#register').modal('show');
                });

                $('#register').on('hide.bs.modal', function() {
                    $('#frmlogin')[0].reset();
                });

                $(window).click(function(event) {
                    if (event.target == $('#register')[0]) {
                        $('#register').modal('hide');
                    }
                });
            });
        </script>

        {{-- FILTRO POR NOMBRE Y ROL SUMATICVO --}}
        <script>
            $('#search, #rol').on('change keyup', function() {
                buscarEmpleado();
            });

            function buscarEmpleado() {
                var searchKeyword = $('#search').val();
                var rolFilter = $('#rol').val();
                $.ajax({
                    url: '{{ route('empleado.buscar') }}',
                    type: 'GET',
                    data: {
                        search: searchKeyword,
                        rol: rolFilter
                    },
                    success: function(response) {
                        $('#tabla').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Error al realizar la búsqueda.');
                    }
                });
            }
        </script>
    @endpush
@else
    @php
        session()->flash('error', 'Debes iniciar sesión para acceder a esta página');
    @endphp

    <script>
        window.location = "{{ route('login') }}";
    </script>
@endif
