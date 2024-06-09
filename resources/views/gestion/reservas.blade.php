@if (session('id'))
    @extends('layouts.plantilla_header')

    @section('title', 'Reservas | MyControlPark')

    @section('token')
        <meta name="csrf_token" content="{{ csrf_token() }}">
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/reservas_empresas.css') }}">
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
            <button onclick="fetchData()" class="btn btn-secondary">Exportar a CSV</button>
        </div>

        <div class="container d-flex justify-content-center align-items-center">
            <div class="row mb-3 w-100">
                <div class="col-md-6 mx-auto">
                    <input type="text" name="filtroNombre" id="filtroNombre" placeholder="Filtrar por matrícula"  class="form-control">
                </div>
            </div>
        </div>

        <div class="column-container">
            <div>
                <p>Pasadas</p>
                <div id="expirados">
                </div>
            </div>
            <div>
                <p>Hoy</p>
                <div id="activos">
                </div>
            </div>
            <div>
                <p>Posteriores</p>
                <div id="nuevos">
                </div>
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
