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
        <h3>Total de usuarios: ({{ $totalEmpleados }})</h3>

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
        <button type="button" class="btn btn-primary" id="abrirModal">Añadir usuario</button>

        {{-- TABLA --}}
        <div id="tabla">
            @include('tablas.tbl_empleados')
        </div>

        {{-- MODAL AÑADIR USUARIO --}}
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="modal-register"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-register">Registrar nuevo empleado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('empleado.store') }}" method="post" id="frmRegistro">
                            @csrf

                            <input type="hidden" name="currentUrl" id="currentUrl">

                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre"
                                    class="form-control" value="{{ isset($empleado) ? $empleado->nombre : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellidos:</label>
                                <input type="text" name="apellido" id="apellido" placeholder="Introduce el apellido"
                                    class="form-control" value="{{ isset($empleado) ? $empleado->apellidos : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" placeholder="Introduce el email"
                                    class="form-control" value="{{ isset($empleado) ? $empleado->email : '' }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDITAR USUARIO --}}
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modal-edit"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-edit">Editar empleado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="currentUrl" id="currentUrl">

                            <div class="form-group">
                                <label for="edit_nombre">Nombre:</label>
                                <input type="text" name="nombre" id="edit_nombre" placeholder="Introduce el nombre"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="edit_apellido">Apellidos:</label>
                                <input type="text" name="apellido" id="edit_apellido"
                                    placeholder="Introduce el apellido" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="edit_email">Email:</label>
                                <input type="email" name="email" id="edit_email" placeholder="Introduce el email"
                                    class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script>
            $(document).ready(function() {
                $('#abrirModal').click(function() {
                    $('#registerModal').modal('show');
                });
            });
        </script>
        
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

        {{-- MOSTRAR MODAL EDITAR USUARIO --}}
        <script>
            $(document).ready(function() {
                $('.btn-edit').click(function(e) {
                    e.preventDefault();
                    var empleadoId = $(this).data('product-id');
                    $.ajax({
                        url: '{{ route('empleado.edit', ['id' => ':id']) }}'.replace(':id',
                            empleadoId),
                        type: 'GET',
                        success: function(response) {
                            $('#editForm').attr('action',
                                '{{ route('empleado.update', ['id' => ':id']) }}'.replace(
                                    ':id', empleadoId));
                            $('#edit_nombre').val(response.nombre);
                            $('#edit_apellido').val(response.apellidos);
                            $('#edit_email').val(response.email);
                            $('#editModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('Error al cargar los datos del usuario.');
                        }
                    });
                });
            });
        </script>

        {{-- FILTRO POR NOMBRE Y ROL SUMATIVO --}}
        <script>
            $('#search, #rol').on('change keyup', function() {
                buscarEmpleado();
            });

            function buscarEmpleado() {
                var searchKeyword = $('#search').val();
                $.ajax({
                    url: '{{ route('empleado.buscar') }}',
                    type: 'GET',
                    data: {
                        search: searchKeyword
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

        <script>
            // Obtener la URL actual del navegador
            var currentUrl = window.location.href;

            // Establecer el valor del campo oculto
            document.getElementById("currentUrl").value = currentUrl;
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
