<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MyControlPark</title>
    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
     {{-- icono --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>

<body>
    <div class="row">
        <div id="cont-logo" class="column-2">
            <img src="{{ asset('img/logo.png') }}" id="logo" alt="Logo">
        </div>
        <div id="cont-form" class="column-2">
            <form class="login-form">
                @csrf
                
                <!-- Manejo de errores y éxito -->
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <h2 class="mb-4 text-center">Inicio de sesión</h2>
                
                <!-- Campo de correo electrónico -->
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Ingresa tu email">
                </div>
                <!-- Campo de contraseña -->
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Ingresa tu contraseña">
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
</body>

</html>
