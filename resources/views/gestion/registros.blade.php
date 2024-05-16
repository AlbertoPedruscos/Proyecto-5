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
@endsection
