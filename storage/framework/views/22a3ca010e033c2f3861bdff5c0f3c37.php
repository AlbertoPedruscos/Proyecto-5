<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MyControlPark</title>
    
    <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/login-register.css')); ?>">
     
    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>">
</head>

<body>
    <div class="row">
        <div id="cont-logo" class="column-2">
            <img src="<?php echo e(asset('img/logo.png')); ?>" id="logo" alt="Logo">
        </div>
        <div id="cont-form" class="column-2">
            <form class="login-form">
                <?php echo csrf_field(); ?>
                
                <!-- Manejo de errores y éxito -->
                <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php endif; ?>
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

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
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views//auth/login.blade.php ENDPATH**/ ?>