@if (session('id'))
    @extends('layouts.plantilla_header')

    @section('title', 'Clientes | MyControlPark')

    @section('token')
        <meta name="csrf_token" content="{{ csrf_token() }}">
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/css/bootstrap.min.css">
    @endsection

    @section('content')
        {{-- NAVBAR --}}
        <header>
            <nav>
                <ul class="nav-left">
                    <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                    <li class="active">Gestores de empresas</li>
                    <li><a href="{{ route('admin_empresa') }}">Empresas</a></li>
                </ul>

                <ul class="nav-right">
                    <li>{{ session('nombre') }}</li>

                    @if (session('nombre_empresa'))
                        <li>{{ session('nombre_empresa') }}</li>
                    @else
                        <li>Empresa no asignada</li>
                    @endif

                    <li><a href="{{ route('logout') }}" style="text-decoration: none;">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>

        <div id="cont_botones" class="my-3">
            {{-- REGISTRAR --}}
            <button id="menu" class="btn btn-outline-dark" data-bs-toggle="modal"
                data-bs-target="#registerModal">Registrar gestor de empresa</button>
            {{-- ELIMINAR MULTIPLE --}}
            <button onclick="selectmuldel()" class="btn btn-outline-danger">Eliminar seleccion</button>
            {{-- QUITAR FILTROS --}}
            <button type="button" class="btn btn-dark">
                <a href="{{ 'admin' }}" style="text-decoration: none; color: white;">Quitar filtros</a>
            </button>
            {{-- EXPORTAR CSV --}}
            {{-- <button type="button" class="btn btn-secondary" id="exportarCSV">
                <a href="{{ route('empleados.exportarCSV') }}" style="text-decoration: none; color: white;">Exportar a CSV</a>
            </button>                     --}}
        </div>

        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="" method="post" id="frmbusqueda" class="d-flex align-items-center">
                        <label for="nombre" class="form-label me-2">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Buscar...">
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="" method="post" id="frmfiltroRol" class="d-flex align-items-center">
                        <label for="rol" class="form-label me-2">Rol:</label>
                        <select name="filtroRol" id="filtroRol" class="form-select">
                            <option value="">Selecciona un rol</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div id="tabla">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col" style="width: 450px">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Seleccionar</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="resultado"></tbody>
            </table>
        </div>

        <!-- MODAL AÑADIR USUARIO -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Registrar usuario de empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="formnewuser">
                            <div class="mb-3">
                                <label for="nombreuser" class="form-label">Nombre</label>
                                <input type="text" name="nombreuser" id="nombreuser" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" name="apellido" id="apellido" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="pwd" class="form-label">Contraseña</label>
                                <input type="password" name="pwd" id="pwd" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="SelecRoles" class="form-label">Rol</label>
                                <select name="SelecRoles" id="SelecRoles" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label for="SelecEmpresa" class="form-label">Empresa</label>
                                <select name="SelecEmpresa" id="SelecEmpresa" class="form-select"></select>
                            </div>
                            <button type="button" class="btn btn-outline-dark" id="registrar">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @push('scripts')
        <script src="{{ asset('/js/admin.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz4fnFO9gybBogGzPbQ7mZPb4U6bfb6Y15QIBTIC1MGpb85jO1+R3L9R8E" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.min.js"
            integrity="sha384-C2LmC6zzGzZJB7b3IcG9ofDr/jK8+r8CWb9NGFfMkg7tWlP8/KnOWw1k4mK3Ez4G" crossorigin="anonymous">
        </script>
    @endpush
@else
    {{-- Establecer el mensaje de error --}}
    @php
        session()->flash('error', 'Debes iniciar sesión para acceder a esta página');
    @endphp

    {{-- Redireccionar al usuario a la página de inicio de sesión --}}
    <script>
        window.location = "{{ route('login') }}";
    </script>

    @csrf
    <script>
        var csrfToken = "{{ csrf_token() }}";
    </script>
@endif
