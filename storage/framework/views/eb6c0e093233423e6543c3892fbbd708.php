<!-- resources/views/auth/login.blade.php -->
 <!-- Extiende la plantilla base -->

<?php $__env->startSection('title', 'Login | MyControlPark'); ?> <!-- Título personalizado -->
<?php $__env->startSection('css'); ?> <!-- CSS personalizado -->
    <link rel="stylesheet" href="<?php echo e(asset('css/login-register.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <header>
        <nav>
            <ul class="nav-left">
                <li><img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo"></li>
            </ul>

            <ul class="nav-right">
                <li><a href="<?php echo e(route('inicio')); ?>">Volver</a></li>
            </ul>
        </nav>
    </header>

    <div class="row">
        <div id="cont-form">
            <form class="login-form" method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>

                <h1 class="mb-4 text-center">Inicio de sesión</h1>

                <!-- Manejo de errores y éxito -->
                <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php endif; ?>
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>


                <!-- Campo de correo electrónico -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" name="email" id="email"
                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Ingresa tu correo electrónico" value="<?php echo e(old('email')); ?>">
                    </div>
                </div>

                <!-- Campo de contraseña -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="password" class="form-label">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Ingresa tu contraseña" value="<?php echo e(old('password')); ?>">
                            <button type="button" id="password-toggle-btn" class="btn btn-outline-secondary"
                                onclick="togglePasswordVisibility()">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <!-- Botón de enviar -->
                    <button id="btn-enviar">Iniciar sesión</button>
                </div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/auth/login.blade.php ENDPATH**/ ?>