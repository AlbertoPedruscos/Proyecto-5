@if (session('id'))
    @extends('layouts.plantilla_header')

    @section('title', 'Reservas | MyControlPark')

    @section('token')
        <meta name="csrf_token" content="{{ csrf_token() }}">
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @endsection

    @section('content')
        <header>
            <nav>
                <ul class="nav-left">
                    <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                    <li><a href="{{ route('gestEmpleados') }}" class="gold-hover">Empleados</a></li>
                    <li class="active">Reservas</li>
                    <li><a href="{{ 'mapa' }}" class="gold-hover">Mapa</a></li>
                    <li><a href="{{ 'historial' }}" class="gold-hover">Historial de actividad de los aparcacoches</a></li>
                    <li><a href="{{ 'ubicaciones' }}" class="gold-hover">Crear ubicaciones</a></li>
                </ul>

                <ul class="nav-right">
                    <!-- Mostrar el nombre del usuario -->
                    <li>{{ session('nombre') }}</li>

                    <!-- Mostrar el nombre de la empresa, si está disponible -->
                    @if (session('nombre_empresa'))
                        <li>{{ session('nombre_empresa') }}</li>
                    @else
                        <li>Empresa no asignada</li> <!-- Mensaje alternativo si no hay empresa -->
                    @endif

                    <!-- Enlace para cerrar sesión -->
                    <li><a href="{{ route('logout') }}">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>

        <div id="cont_botones">
            <button type="button" class="btn btn-dark" style="border-radius: 5px;">
                <a href="{{ 'reservas' }}" style="text-decoration: none; color: white;">Quitar filtros</a>
            </button>
            
            <button onclick="fetchData()" class="btn btn-secondary">Exportar a CSV</button>
        </div>
        
        <div style="background-image: url('{{ asset('img/fondo_crud.jpg') }}'); background-size: cover; background-position: center; ">

        </div>
        
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row mb-3 w-100">
                <div class="d-flex justify-content-between p-3 border border-dark rounded">
                    <form action="" method="post" id="frmbusqueda1" class="d-flex align-items-center form-inline">
                        <div class="form-group me-3">
                            <label for="nombre" class="form-label me-2">Matrícula:</label>
                            <input type="text" name="filtroNombre" id="filtroNombre" placeholder="Filtrar por matrícula"
                                class="form-control">
                        </div>
                    </form>
                    <form action="" method="post" id="frmbusqueda2" class="d-flex align-items-center form-inline">
                        <div class="form-group me-3">
                            <label for="Fecha" class="form-label me-2">Fecha inicio:</label>
                            <input type="date" name="fechaini" id="fechaini" class="form-control">
                        </div>
                    </form>
                    <form action="" method="post" id="frmbusqueda3" class="d-flex align-items-center form-inline">
                        <div class="form-group">
                            <label for="nombre" class="form-label me-2">Fecha fin:</label>
                            <input type="date" name="fechafin" id="fechafin" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
                
        <div>
            <div id="tabla" class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Trabajador</th>
                            <th style="width: 100px;">Parking</th>
                            <th>Plaza</th>
                            <th style="width: 55px">Matricula</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Punto recogida</th>
                            <th>Punto entrega</th>
                            <th>Fecha entrada</th>
                            <th>Firma entrada</th>
                            <th>Fecha salida</th>
                            <th>Firma salida</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
    
                    <tbody id="resultado"></tbody>
                </table>
            </div>
        </div>

    @endsection
    @push('scripts')
        <script src="{{ asset('/js/reservas.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
