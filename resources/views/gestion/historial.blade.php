@extends('layouts.plantilla_header')

@section('title', 'Historial | MyControlPark')

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
        <body id="fondo_crud">       
            <header>
                <nav>
                    <ul class="nav-left">
                        <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                        <li><a href="{{ url('gestEmpleados') }}">Empleados</a></li>
                        <li><a href="{{ url('reservas') }}">Reservas</a></li>
                        <li><a href="{{ url('mapa') }}">Mapa</a></li>
                        <li class="active">Historial de reservas</li>
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
                {{-- BOTÓN PARA VOLVER A LA PÁGINA PRINCIPAL POR DEFECTO --}}
                <button type="button" class="btn btn-dark" style="border-radius: 5px;">
                    <a href="{{ 'historial' }}" style="text-decoration: none; color: white;">Quitar filtros</a>
                </button>
    
                {{-- BOTÓN PARA EXPORTAR A CSV --}}
                <button type="button" class="btn btn-secondary" style="border-radius: 5px;">
                    <a href="{{ route('historial.exportarCSV', ['usuario' => request('usuario'), 'orden' => request('orden')]) }}"
                        style="text-decoration: none; color: white;">Exportar a CSV</a>
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
    
            <div id="tabla">
                @include('tablas.tbl_registros')
            </div>
        </body>
    @endsection
@else
    @php
        header('Location: ' . route('login'));
        exit();
    @endphp
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('usuarios_select').addEventListener('change', function() {
                actualizarTabla();
            });

            document.getElementById('orden_select').addEventListener('change', function() {
                actualizarTabla();
            });

            function actualizarTabla() {
                var usuarioId = document.getElementById('usuarios_select').value;
                var orden = document.getElementById('orden_select').value;

                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Actualizar la tabla con los datos recibidos
                            document.getElementById('tabla').innerHTML = xhr.responseText;
                        } else {
                            console.error('Hubo un error en la solicitud.');
                        }
                    }
                };
                xhr.open('GET', '{{ route('actualizar.tabla') }}?usuario=' + usuarioId + '&orden=' + orden, true);
                xhr.send();
            }
        });
    </script>
@endpush
