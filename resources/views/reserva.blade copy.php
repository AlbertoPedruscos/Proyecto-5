@extends('layouts.plantilla_header')

@section('title', 'Inicio | MyControlPark')
@section('token')
    <meta name="csrf_token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
    <nav>
        <ul class="nav-left">
            <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
        </ul>

        <ul class="nav-right">
            <li><a href="">Sobre nosotros</a></li>
            <li><a href="">Contáctanos</a></li>
            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
        </ul>
    </nav>

    <div id="formulario">
        <div id="cont-form">
            <h1>Haga su reserva</h1>
            <form action="/gi" method="post" id="FrmReserva" class="form-floating">
                <!-- Datos personales -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="nom_cliente" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nom_cliente" name="nom_cliente" placeholder="Introduce tu nombre">
                    </div>
                    <div class="form-field">
                        <label for="num_telf" class="form-label">Teléfono:</label>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="num_telf" name="num_telf" placeholder="Introduce tu teléfono">
                            <p id="mensajeErrorT" style="color: red;"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-field">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu email">
                        <p id="mensajeErroremail" style="color: red;"></p>
                    </div>
                </div>
                <!-- Datos del coche -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="matricula" class="form-label">Matrícula:</label>
                        <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula">
                        <p id="mensajeError" style="color: red;"></p>
                    </div>
                    <div class="form-field">
                        <label for="marca" class="form-label">Marca:</label>
                        <select id="cochesSelect" class="form-select" aria-label="Default select example">
                            <option value="0" selected disabled>Selecciona un coche...</option>
                          </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-field">
                        <label for="modelo" class="form-label">Modelo:</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo">
                    </div>
                    <div class="form-field">
                        <label for="color" class="form-label">Color:</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder="Color">
                    </div>
                </div>

                <!-- Detalles de la reserva -->
                <div class="form-group">
                    <div class="form-field">
                        <label for="ubicacion_entrada" class="form-label">Punto de recogida:</label>
                        <select class="form-select" aria-label="Default select example" name="ubicacion_entrada" id="ubicacion_entrada">
                            <option value="Aeropuerto T1">Aeropuerto T1</option>
                            <option value="Aeropuerto T2">Aeropuerto T2</option>
                            <option value="Puerto">Puerto</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="ubicacion_salida" class="form-label">Punto de entrega:</label>
                        <select class="form-select" aria-label="Default select example" name="ubicacion_salida" id="ubicacion_salida">
                            <option value="Aeropuerto T1">Aeropuerto T1</option>
                            <option value="Aeropuerto T2">Aeropuerto T2</option>
                            <option value="Puerto">Puerto</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-field">
                        <label for="fecha_entrada" class="form-label">Fecha de Entrada:</label>
                        <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada">
                    </div>
                    <div class="form-field">
                        <label for="fecha_salida" class="form-label">Fecha de Salida:</label>
                        <input type="datetime-local" class="form-control" id="fecha_salida" name="fecha_salida" disabled>
                    </div>
                </div>
            </div>
                <div>
                    <button type="button" id="form-btn" class="btn btn-dark" onclick="reservarNuevo()">Enviar</button>
                </div>
            </form>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        var formbtn = document.getElementById('form-btn');
        function reservarNuevo() {
            var form = document.getElementById('FrmReserva');
            var formdata = new FormData(form);

            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/reservaO');

            ajax.onload = function() {
                if (ajax.status === 200) {
                    if (ajax.responseText === "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: '¡El vehiculo ha sido reservado!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        form.reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Hubo un problema al reservar el vehículo!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'asd',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            };

            ajax.send(formdata);
        }
        // VALIDACIONES

        document.addEventListener("DOMContentLoaded", function() {
            var matriculaInput = document.getElementById("matricula");
            var mensajeError = document.getElementById("mensajeError");

            matriculaInput.addEventListener("input", function() {
                var matricula = matriculaInput.value.trim();

                var valor = matriculaInput.value.toUpperCase(); // Convertir a mayúsculas
                var regex = /^[A-Z0-9]*$/;
                matriculaInput.value = valor; // Establecer el valor del campo de entrada con el texto formateado

                if (!regex.test(valor)) {
                    // Si se ingresa un carácter especial que no sea letra o número, eliminarlo del valor del input
                    matriculaInput.value = valor.replace(/[^A-Z0-9]/g, '');
                }

                if (validarMatricula(matricula)) {
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                }else if (validarMatriculaF(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                }else if (validarMatriculaA(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                }else if (validarMatriculaU(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                } else if (validarMatriculaH(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                } else if (validarMatriculaRU(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                } else if (validarMatriculaSU(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                } else if (validarMatriculaH2(matricula)){
                    mensajeError.textContent = "";
                    mensajeError.style.margin = "0";
                    formbtn.disabled = false;
                } else {
                    mensajeError.textContent = "Formato de matrícula no válido";
                    formbtn.disabled = true;
                }
            });
            

            function validarMatricula(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^\d{4}[A-Za-z]{3}$/;
                return regex.test(matricula);
            }
            function validarMatriculaF(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^[A-Za-z]{2}\d{3}[A-Za-z]{2}$/;
                return regex.test(matricula);
            }
            function validarMatriculaU(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^[A-Za-z]{2}\d{4}[A-Za-z]{2}$/;
                return regex.test(matricula);
            }
            function validarMatriculaA(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^[A-Za-z]{1}\d{4}$/;
                return regex.test(matricula);
            }
            function validarMatriculaH(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^[A-Za-z]{2}\d{3}[A-Za-z]{1}$/;
                return regex.test(matricula);
            }
            function validarMatriculaRU(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{3}$/;
                return regex.test(matricula);
            }
            function validarMatriculaSU(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^[A-Za-z]{2}\d{6}$/;
                return regex.test(matricula);
            }
            function validarMatriculaH2(matricula) {
                // Aquí puedes escribir tu lógica de validación para la matrícula
                // Por ejemplo, si la matrícula debe tener un formato específico
                // como tres letras seguidas de tres números, podrías hacer algo como esto:
                var regex = /^\d{1}[A-Za-z]{3}\d{2}$/;
                return regex.test(matricula);
            }
            // NOMBRE
            var inputNombre = document.getElementById("nom_cliente");

            inputNombre.addEventListener("input", function() {
            var texto = inputNombre.value.toLowerCase(); // Convertir todo el texto a minúsculas
            texto = texto.replace(/\b\w/g, function(l) { // Reemplazar cada letra que sigue un límite de palabra
                return l.toUpperCase(); // con su versión en mayúscula
            });
            inputNombre.value = texto; // Establecer el valor del campo de entrada con el texto formateado
            });


            // EMAIL


            var email = document.getElementById("email");

            email.addEventListener("input", function() {
                var texto = email.value.toLowerCase(); // Convertir todo el texto a minúsculas
                email.value = texto; // Establecer el valor del campo de entrada con el texto formateado
            });
            email.addEventListener("blur", function() {
            if (!validarDominio(email.value)) {
                // alert("Por favor, introduce un correo electrónico con un dominio válido.");
                mensajeErroremail.textContent = "Por favor, introduce un correo electrónico con un dominio válido.";
                email.value = ""; // Limpiar el campo si el dominio no es válido
            } else {
                mensajeErroremail.textContent = "";
                mensajeErroremail.style.margin = "0";
            }
            });
            function validarDominio(email) {
                var dominioValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                return dominioValido;
            }

            // TELEFONO

            num_telf.addEventListener("input", function() {
      var numero = num_telf.value.trim();
      var mensajeErrorT = document.getElementById("mensajeErrorT");


      // Reemplazar espacios y letras por una cadena vacía
      num_telf.value = num_telf.value.replace(/\s/g, '').replace(/[a-zA-Z]/g, '');

      // Si el número no empieza por 6, limpiar el campo y mostrar un mensaje de error
      if (numero.charAt(0) !== '6' && numero.charAt(0) !== '9' && numero.charAt(0) !== '7') {
        num_telf.value = "";
        formbtn.disabled = true;
        mensajeErrorT.textContent = "El número de teléfono debe empezar por 6, 7 o 9.";
        // mensajeError.style.marginTop = "10px"; // Añadir un margen superior al mensaje de error
        return;
      }

      // Limitar la longitud a 9 caracteres
      if (numero.length > 9) {
        num_telf.value = numero.slice(0, 9); // Truncar el número a 9 caracteres
      }

      if (validarNumero(num_telf.value)) {
        mensajeErrorT.textContent = ""; // Limpiar el mensaje de error
        mensajeErrorT.style.marginTop = "0"; // Establecer el margen superior a 0
      } else {
        mensajeErrorT.textContent = "El número de teléfono debe contener exactamente 9 dígitos.";
        formbtn.disabled = true;
        // mensajeError.style.marginTop = "10px"; // Añadir un margen superior al mensaje de error
      }
    });

    function validarNumero(numero) {
      var regex = /^\d{9}$/; // El número debe tener exactamente 9 dígitos
      return regex.test(numero);
    }

    function validarColor(input) {
    // Expresión regular para validar colores con las especificaciones dadas
    var regex = /^[A-Z][a-z]*\s[A-Z][a-z]*$/;
    
    // Comprobar si el valor del input coincide con la expresión regular
    if (regex.test(input.value)) {
        input.style.borderColor = ""; // Establecer borde a su estado original si es válido
        return true;
    } else {
        // Convertir todo el texto a minúsculas
        var texto = input.value.toLowerCase();
        // Dividir el texto en palabras
        var palabras = texto.split(" ");
        // Limitar la cantidad de palabras a dos
        palabras = palabras.slice(0, 2);
        // Capitalizar la primera letra de cada palabra
        for (var i = 0; i < palabras.length; i++) {
            palabras[i] = palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1);
        }
        // Unir las palabras nuevamente en una cadena con un solo espacio entre ellas
        var textoFormateado = palabras.join(" ");
        input.value = textoFormateado; // Establecer el valor del campo de entrada con el texto formateado
        // input.style.borderColor = "red"; // Establecer borde rojo ya que la entrada no es válida
        return false;
    }
}

// Ejemplo de uso:
var inputColor = document.getElementById("color");

inputColor.addEventListener("input", function() {
    validarColor(this);
});



// FECHA ENTRADA

function validarFecha(input) {
    var fechaIngresada = new Date(input.value);
    var fechaActual = new Date();
    
    // Obtener la fecha actual en milisegundos
    var fechaActualMS = fechaActual.getTime();
    // Agregar 10 minutos (10 * 60 * 1000 milisegundos) a la fecha actual
    var fechaMinimaPermitidaMS = fechaActualMS + (10 * 60 * 1000);

    // Comprobar si la fecha ingresada es válida
    if (!isNaN(fechaIngresada.getTime())) {
        // Comprobar si la fecha ingresada es mayor o igual que la fecha actual y si es mayor o igual que la fecha actual + 10 minutos
        if (fechaIngresada >= fechaActual && fechaIngresada >= new Date(fechaMinimaPermitidaMS)) {
            input.setCustomValidity(""); // La fecha es válida
            input.style.borderColor = ""; // Establecer borde a su estado original si es válida
            var inputSalida = document.getElementById("fecha_salida");
            inputSalida.disabled = false; // Habilitar el campo de fecha de salida
            formbtn.disabled = true;
            return true;
        } else {
            input.setCustomValidity("La fecha debe ser igual o mayor que la fecha actual y al menos 10 minutos de margen"); // Mensaje de error personalizado
            input.style.borderColor = "red"; // Establecer borde rojo si no es válida
            fechaIngresada.value = ""; // Vaciar el campo de fecha si la fecha ingresada no es válida
            var inputSalida = document.getElementById("fecha_salida");
            inputSalida.disabled = true; // Deshabilitar el campo de fecha de salida
            formbtn.disabled = true;
            return false;
        }
    } else {
        input.value = ""; // Vaciar el campo de fecha si la fecha ingresada no es válida
        input.setCustomValidity("Formato de fecha inválido."); // Mensaje de error personalizado
        input.style.borderColor = "red"; // Establecer borde rojo si no es válida
        var inputSalida = document.getElementById("fecha_salida");
        inputSalida.disabled = true; // Deshabilitar el campo de fecha de salida
        formbtn.disabled = true;
        return false;
    }
}


// Ejemplo de uso:
var inputFecha = document.getElementById("fecha_entrada");

inputFecha.addEventListener("input", function() {
    validarFecha(this);
});

// FECHA SALIDA


function validarFechaSalida(inputSalida, inputEntrada) {
    var fechaSalida = new Date(inputSalida.value);
    var fechaEntrada = new Date(inputEntrada.value);
    
    // Agregar 5 horas (5 * 60 * 60 * 1000 milisegundos) a la fecha de entrada
    var fechaMinimaPermitidaMS = fechaEntrada.getTime() + (5 * 60 * 60 * 1000);

    // Comprobar si la fecha de salida es válida y si es al menos 5 horas después de la fecha de entrada
    if (!isNaN(fechaSalida.getTime()) && fechaSalida >= new Date(fechaMinimaPermitidaMS)) {
        inputSalida.setCustomValidity(""); // La fecha es válida
        inputSalida.style.borderColor = ""; // Establecer borde a su estado original si es válida
        formbtn.disabled = false;
        return true;
    } else {
        inputSalida.setCustomValidity("La fecha de salida debe ser al menos 5 horas después de la fecha de entrada."); // Mensaje de error personalizado
        inputSalida.style.borderColor = "red"; // Establecer borde rojo si no es válida
        formbtn.disabled = true;
        return false;
    }
}

// Ejemplo de uso:
var inputSalida = document.getElementById("fecha_salida");
var inputEntrada = document.getElementById("fecha_entrada");

inputSalida.addEventListener("input", function() {
    validarFechaSalida(this, inputEntrada);
});







            var cochesSelect = document.getElementById("cochesSelect");
    // Crear una nueva solicitud XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Parsear la respuesta JSON
        var data = JSON.parse(this.responseText);
        // Iterar sobre los datos y agregar opciones al select
        data.forEach(coche => {
          var option = document.createElement("option");
          option.value = coche.id;
          option.textContent = coche.marca;
          cochesSelect.appendChild(option);
        });
      }
    };
    
    // Abrir y enviar la solicitud
    xhr.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/coches", true);
    xhr.send();
        });

    </script>
@endpush