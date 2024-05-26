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
                <!-- Contenido de la barra de navegación -->
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

        {{-- FORMULARIO FILTRO Y PÁGINA --}}
        <form id="filterForm" method="GET">
            <label for="perPage">Elementos por página:</label>
            <select name="perPage" id="perPage">
                <option value="5" {{ Request::get('perPage') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ Request::get('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ Request::get('perPage') == 15 ? 'selected' : '' }}>15</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        {{-- TABLA --}}
        <div id="tabla">
            @include('tablas.tbl_empleados')
        </div>

        {{-- REGISTRAR USUARIO --}}
        <button type="button" class="btn btn-primary" id="abrirModal">Añadir usuario</button>

        {{-- MODAL AÑADIR USUARIO --}}
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="modal-register"
            aria-hidden="true">
            {{-- Contenido del modal de añadir usuario --}}
        </div>
    @endsection
@else
    @php
        header('Location: ' . route('login'));
        exit();
    @endphp
@endif

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7+Yj7/6/gqH1D00iW6c+zo5FJ3w7QaXK/z6ZC9Yg" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js" integrity="sha384-B4tt8/DBP0LbRULaFO15QwEReKo0+kTPrUN6RfFzAD5SMoFfO+Xt5Jx5W2c6Xg7L" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9b4Is3NZoJ6wTrFjjGmkjFw8LLAPk2vRT0TctW7NO3S1Zef6j5oaJXp" crossorigin="anonymous"></script>
    <script src="{{ asset('js/empleados.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Manejar el evento de cambio en el select de perPage
            $('#perPage').on('change', function() {
                $('#filterForm').submit(); // Enviar el formulario cuando se cambie el número de elementos por página
            });
        });
    </script>
@endpush
