@extends('layouts.plantilla_header')

@section('title', 'Plazas párking | MyControlPark')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/plazas.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<header>
    <nav>
        <ul class="nav-left">
            <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
            <li><a href="{{ route('gestEmpleados') }}">Empleados</a></li>
            <li><a href="{{ 'reservas' }}">Reservas</a></li>
            <li><a href="{{ 'mapa' }}">Mapa</a></li>
            <li><a href="{{ 'historial' }}">Historial de reservas</a></li>
            <li><a href="{{ 'ubicaciones' }}">Crear ubicaciones</a></li>
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

<div class="parking-info" style="padding-top: 120px">
    <h1>{{ $parking->nombre }} - </h1> <!-- Mostrar el nombre del parking -->
    <h2>Total de plazas: {{ count($plazas) }}   </h2> <!-- Mostrar el conteo de plazas -->
    <button class="btn btn-outline-dark"><a href="{{ route('mapa') }}"><i class="fas fa-long-arrow-alt-left"></i></a></button>
</div>

<div id="gridContainer">
    <!-- Iterar sobre todas las plazas de aparcamiento -->
    @foreach($plazas as $plaza)
        <div class="cuadro">
            <!-- Determinar la imagen según el estado de la plaza -->
            <img src="@if($plaza->id_estado == 1) {{ asset('img/car2.svg') }} @elseif($plaza->id_estado == 2) {{ asset('img/car1.svg') }} @else {{ asset('img/car3.svg') }} @endif" class="imagen" alt="Plaza de Aparcamiento">
            <div class="cuadrado-negro"></div>
            <div class="texto">{{ $plaza->nombre }}</div>
            <!-- Mostrar el estado correspondiente -->
            <div class="texto">
                @if($plaza->id_estado == 1)
                    Ocupado
                @elseif($plaza->id_estado == 2)
                    Libre
                @else
                    Reservado
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection
