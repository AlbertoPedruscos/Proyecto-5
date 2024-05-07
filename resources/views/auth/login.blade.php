<!-- resources/views/auth/login.blade.php -->
@extends('layouts.plantilla_header') <!-- Extiende la plantilla base -->

@section('title', 'Login | MyControlPark') <!-- Título personalizado -->
@section('css') <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
    {{-- FUENTE --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div id="cont-logo" class="column-2">
            <img src="{{ asset('img/logo.png') }}" id="logo" alt="Logo">
        </div>
        <div id="cont-form" class="column-2">
            <form class="login-form" method="POST" action="{{ route('login.post') }}">
                @csrf

                <h2 class="mb-4 text-center">Inicio de sesión</h2>

                <!-- Manejo de errores y éxito -->
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif


                <!-- Campo de correo electrónico -->
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Ingresa tu correo electrónico" value="{{ old('email') }}">
                </div>

                <!-- Campo de contraseña -->
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Ingresa tu contraseña"
                            value="{{ old('password') }}">
                        <button type="button" id="password-toggle-btn" class="btn btn-outline-secondary"
                            onclick="togglePasswordVisibility()">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
                <!-- Botón de enviar -->
                <button id="btn-enviar" class="btn btn-primary w-100">Iniciar sesión</button>
            </form>
        </div>
    </div>

    <!-- Script para alternar la visibilidad de la contraseña -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const passwordToggleBtn = document.getElementById("password-toggle-btn");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggleBtn.innerHTML = '<i class="far fa-eye-slash"></i>'; // Cambiar ícono a ojo tachado
            } else {
                passwordInput.type = "password";
                passwordToggleBtn.innerHTML = '<i class="far fa-eye"></i>'; // Cambiar ícono a ojo abierto
            }
        }
    </script>
@endsection
