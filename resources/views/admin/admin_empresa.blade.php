@if (session('id'))
    @extends('layouts.plantilla_header')

    @section('title', 'Empresas | MyControlPark')

    @section('token')
        <meta name="csrf_token" content="{{ csrf_token() }}">
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @endsection

    @section('content')
        {{-- NAVBAR --}}
        <header>
            <nav>
                <ul class="nav-left">
                    <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                    <li><a href="{{ route('admin') }}" style="text-decoration: none;">Gestores de empresa</a></li>
                    <li class="active">Empresas</li>
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

        <div id="cont_botones">
            <button id="menu" class="btnregister btn btn-outline-dark" data-bs-toggle="modal"
                data-bs-target="#registerModal">Registrar una empresa</button>
            <div id="rolfiltros" class="d-flex justify-content-end align-items-center">
                <button onclick="selectmuldel()" class="btn btn-outline-danger">Eliminar seleccion</button>
            </div>
            <button type="button" class="btn btn-dark">
                <a href="{{ 'admin_empresa' }}" style="text-decoration: none; color: white;">Quitar filtros</a>
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

        <div class="container d-flex justify-content-center align-items-center">
            <div class="row mb-3 w-100">
                <div class="col-md-6 mx-auto">
                    <form action="" method="post" id="frmbusqueda"
                        class="d-flex align-items-center justify-content-center">
                        <label for="nombre" class="form-label me-2">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            placeholder="Buscar por nombre de empresa...">
                    </form>
                </div>
            </div>
        </div>

        <div id="tabla" style="padding-left: 0;">
            <table class="table table-bordered table-hover" style="margin-left: 0;">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Seleccionar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="resultado"></tbody>
            </table>
        </div>
        
        <!-- MODAL AÑADIR EMPRESA -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Registrar una empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formnewuser" action="{{ route('empresa.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nombre de la empresa</label>
                                <input type="text" name="nombreuser" id="nombreuser" class="form-control">
                            </div>
                            <button type="button" class="btn btn-outline-dark" id="registrar">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="{{ asset('/js/admin_empresas.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
