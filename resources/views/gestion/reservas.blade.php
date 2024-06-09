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

            <div class="container d-flex justify-content-center align-items-center">
                <div class="row mb-3 w-50">
                    <div>
                        <form action="" method="post" id="frmbusqueda" class="d-flex align-items-center">
                            <label for="nombre" class="form-label me-2">Matricula:</label>
                            <input type="text" name="filtroNombre" id="filtroNombre" placeholder="Filtrar por matrícula"
                                class="form-control">
                        </form>
                    </div>
                    <div>
                        <form action="" method="post" id="frmbusqueda" class="d-flex align-items-center">
                            <label for="Fecha" class="form-label me-2">Fecha inicio:</label>
                            <input type="date" name="fechaini" id="fechaini" class="form-control">
                        </form>
                    </div>
                    <div>
                        <form action="" method="post" id="frmbusqueda" class="d-flex align-items-center">
                            <label for="nombre" class="form-label me-2">Fecha fin:</label>
                            <input type="date" name="fechafin" id="fechafin" class="form-control">
                        </form>
                    </div>
                </div>
            </div> <button onclick="fetchData()" class="btn btn-secondary">Exportar a CSV</button>
        </div>




        <div id="tabla">
            <table style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>trabajador</th>
                        <th>parking</th>
                        <th>plaza</th>
                        <th>matricula</th>
                        <th>marca</th>
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
                        <th>accion</th>
                    </tr>
                </thead>
                <tbody id="resultado"></tbody>
            </table>
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
