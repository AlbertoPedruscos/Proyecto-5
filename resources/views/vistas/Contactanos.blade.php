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
            <li><a href="{{ route('inicio') }}">Reservar</a></li>
            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
        </ul>
    </nav>

    <div id="formulario">
        <div id="cont-form">
            <h1>Haga su reserva</h1>
            <form action="" method="post" id="FrmContactanos" class="form-floating" onsubmit="Contactanos()">
                <div class="form-floating inputs">
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nom_cliente" id="nom_cliente">
                                <label for="floatingInputValue">Nombre</label>
                            </div>
                            <div class="invalid-feedback" id="error-nombre" style="display: none;">
                                El nombre no puede estar vacio.
                            </div>                                          
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="apellidos" id="apellidos">
                                <label for="floatingInputValue">apellido/s</label>
                            </div>
                            <div class="invalid-feedback" id="error-apellidos" style="display: none;">
                                El apellido/s no puede estar vacio.
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select class="form-select" name="prefijo" id="prefijo"
                                    aria-label="Floating label select example">
                                    <option selected disabled>Seleccione su prefijo</option>
                                    <!-- Opciones de prefijo aquí -->
                                </select>
                                <label for="floatingSelect">Prefijo</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="num_telf" id="num_telf"
                                    placeholder="Enter your phone number..." disabled>
                                <label for="floatingInputValue">Teléfono</label>
                            </div>
                            <div class="invalid-feedback" id="error-telf" style="display: none;">
                                Formato de teléfono incorrecto.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="name@example.com">
                            <label for="floatingInputGrid">Email</label>
                        </div>
                        <div class="invalid-feedback" id="error-email" style="display: none;">
                            Formato de email incorrecto.
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="invalidCheck2" required>
                            <label class="form-check-label" for="invalidCheck2">
                                He leído y acepto los <a style="color: blue;" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">términos y condiciones de uso</a>.
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="form-btn" class="btn btn-dark">Enviar</button>
                    </div>
            </form>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="height: 90vh;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Términos y Condiciones de Uso - Servicios de
                            Aparcacoches</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: scroll;">
                        <p>Por favor, lea atentamente los siguientes términos y condiciones antes de utilizar los servicios
                            de aparcacoches proporcionados a través de nuestra entidad. Al utilizar nuestros servicios,
                            usted acepta estar legalmente vinculado por estos términos y condiciones.</p>

                        <h4>1. Descripción del Servicio</h4>
                        <p>Como intermediarios, facilitamos el uso del servicio de aparcacoches proporcionado por la empresa
                            a la que ha contratado el servicio en cuestión . Al utilizar nuestro servicio, la Empresa
                            proporcionará un espacio seguro para estacionar su vehículo durante el tiempo acordado. El
                            servicio incluye la recepción, custodia y devolución de su vehículo en el lugar designado por la
                            Empresa.</p>

                        <h4>2. Procedimiento de Entrega del Vehículo</h4>
                        <p>Para utilizar nuestro servicio de aparcacoches, usted deberá entregar su vehículo junto con la
                            llave correspondiente a los empleados designados por la Empresa. Al hacer esto, usted entiende y
                            acepta lo siguiente:
                        <ul>
                            <li>La entrega de la llave es indispensable para facilitar el estacionamiento y la movilidad de
                                los vehículos dentro de las instalaciones de la Empresa.</li>
                            <li>En el caso de que la llave entregada contenga objetos adicionales que dificulten su manejo
                                (por ejemplo, llaveros voluminosos, dispositivos electrónicos, etc.), usted acepta que
                                dichos objetos puedan ser retirados y colocados dentro del vehículo para facilitar la
                                gestión de la llave.</li>
                            <li>La Empresa podrá colocar una etiqueta u otro elemento identificativo en la llave del
                                vehículo para garantizar una correcta identificación y manejo durante el servicio de
                                aparcacoches.</li>
                        </ul>
                        </p>
                        <h4>3. Responsabilidades del Intermediario</h4>
                        <p>Como intermediarios, nuestro objetivo es garantizar que el servicio proporcionado por la Empresa
                            cumpla con los más altos estándares de calidad y seguridad. Facilitamos la comunicación y
                            coordinación entre el Cliente y la Empresa, asegurándonos de que todas las necesidades y
                            expectativas sean atendidas adecuadamente.</p>

                        <h4>4. Responsabilidades de la Empresa</h4>
                        <p>La Empresa se compromete a tomar todas las precauciones razonables para garantizar la seguridad
                            de su vehículo mientras esté bajo su custodia. Sin embargo, la Empresa no será responsable de
                            daños, pérdidas o robos que pudieran ocurrir, salvo en casos de negligencia comprobada por parte
                            de la Empresa.</p>

                        <h4>5. Responsabilidades del Usuario</h4>
                        <p>Como usuario de nuestro servicio, usted acepta ser responsable de cualquier daño causado a su
                            vehículo como resultado de su propio manejo o negligencia. Además, reconoce que es responsable
                            de cualquier objeto personal dejado dentro del vehículo y exime a la Empresa y al intermediario
                            de cualquier responsabilidad al respecto.</p>

                        <h4>6. Tarifas y Pagos</h4>
                        <p>Las tarifas por el servicio de aparcacoches serán establecidas por la Empresa y comunicadas al
                            usuario antes de la prestación del servicio. Al utilizar nuestro servicio, usted acepta pagar
                            las tarifas correspondientes según lo acordado. Los pagos deberán realizarse de acuerdo con las
                            instrucciones proporcionadas por el intermediario y/o la Empresa.</p>

                        <h4>7. Duración y Terminación</h4>
                        <p>Este acuerdo entrará en vigor al utilizar nuestros servicios y permanecerá vigente hasta la
                            devolución de su vehículo. Nos reservamos el derecho de rescindir este acuerdo en cualquier
                            momento si consideramos que su conducta o acciones ponen en riesgo la seguridad o integridad de
                            nuestro servicio o de la Empresa.</p>

                        <h4>8. Legislación Aplicable y Jurisdicción</h4>
                        <p>Este acuerdo se regirá e interpretará de acuerdo con las leyes del [país/estado/provincia].
                            Cualquier disputa relacionada con estos términos y condiciones estará sujeta a la jurisdicción
                            exclusiva de los tribunales de [ciudad/país/estado/provincia].</p>

                        <h4>9. Manejo de Datos Personales</h4>
                        <p>Al completar y enviar el formulario de reserva, usted acepta que el intermediario y la Empresa
                            recopilen, almacenen y utilicen sus datos personales para la gestión y prestación del servicio
                            de aparcacoches. Sus datos serán tratados con la máxima confidencialidad y de acuerdo con las
                            leyes y regulaciones aplicables sobre protección de datos. Usted tiene derecho a acceder,
                            rectificar y eliminar sus datos personales en cualquier momento, así como a retirar su
                            consentimiento para su tratamiento, contactándonos a través de [información de contacto del
                            intermediario o de la Empresa].</p>

                        <h4>10. Modificaciones y Actualizaciones</h4>
                        <p>Nos reservamos el derecho de modificar o actualizar estos términos y condiciones en cualquier
                            momento. Cualquier cambio será efectivo inmediatamente después de su publicación en nuestro
                            sitio web o mediante notificación directa a los usuarios. Es su responsabilidad revisar
                            periódicamente estos términos y condiciones para estar al tanto de cualquier cambio.</p>

                        <h4>11. Aceptación de los Términos</h4>
                        <p>Al utilizar nuestros servicios, usted acepta estos términos y condiciones en su totalidad. Si no
                            está de acuerdo con alguno de los términos establecidos aquí, le rogamos que no utilice nuestro
                            servicio de aparcacoches.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var formbtn = document.getElementById('form-btn');

            function ContactanosNuevo() {
                var form = document.getElementById('FrmReserva');
                var formdata = new FormData(form);

                var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
                formdata.append('_token', csrfToken);
                formdata.forEach(function(value, key) {
                    console.log(key + ': ' + value);
                });
                var ajax = new XMLHttpRequest();
                ajax.open('POST', '/ContactanosNuevo');

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
                            icon: 'warning',
                            title: '!Comprueba los campos¡ <br> O <br> Contacta con la empresa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                };

                ajax.send(formdata);
            }

            // VALIDACIONES

            document.addEventListener("DOMContentLoaded", function() {

                var inputNombre = document.getElementById("nom_cliente");
                var errornombre = document.getElementById("error-nombre");

                inputNombre.addEventListener("blur", function() {
                    var texto = this.value.replace(/\d/g, ''); // Eliminar números del texto ingresado
                    texto = texto.toLowerCase().replace(/\b\w/g, function(
                        l
                    ) { // Convertir todo el texto a minúsculas y capitalizar la primera letra de cada palabra
                        return l.toUpperCase();
                    });
                    this.value = texto; // Establecer el valor del campo de entrada con el texto formateado

                    if (texto.trim() === '') { // Verificar si el campo está vacío
                        document.getElementById("nom_cliente").classList.remove("is-valid");
                        document.getElementById("nom_cliente").classList.add("is-invalid");
                        errornombre.style.display = 'block';
                        return false;
                    } else {
                        document.getElementById("nom_cliente").classList.remove("is-invalid");
                        document.getElementById("nom_cliente").classList.add("is-valid");
                        errornombre.style.display = 'none';
                        return true;
                    }
                });

                // Apellido

                var inputapellidos = document.getElementById("apellidos");
                var errorapellidos = document.getElementById("error-apellidos");

                inputapellidos.addEventListener("blur", function() {
                    var texto = this.value.replace(/\d/g, ''); // Eliminar números del texto ingresado
                    texto = texto.toLowerCase().replace(/\b\w/g, function(
                        l
                    ) { // Convertir todo el texto a minúsculas y capitalizar la primera letra de cada palabra
                        return l.toUpperCase();
                    });
                    this.value = texto; // Establecer el valor del campo de entrada con el texto formateado

                    if (texto.trim() === '') { // Verificar si el campo está vacío
                        document.getElementById("apellidos").classList.remove("is-valid");
                        document.getElementById("apellidos").classList.add("is-invalid");
                        errorapellidos.style.display = 'block';
                        return false;
                    } else {
                        document.getElementById("apellidos").classList.remove("is-invalid");
                        document.getElementById("apellidos").classList.add("is-valid");
                        errorapellidos.style.display = 'none';
                        return true;
                    }
                });

                // EMAIL

                var email = document.getElementById("email");
                var erroremail = document.getElementById('error-email');
                email.addEventListener("input", function() {
                    var texto = email.value.toLowerCase(); // Convertir todo el texto a minúsculas
                    email.value = texto; // Establecer el valor del campo de entrada con el texto formateado
                    erroremail.style.display = "none";
                });
                email.addEventListener("blur", function() {
                    document.getElementById("email").classList.remove("is-invalid");
                    document.getElementById("email").classList.add("is-valid");
                    if (!validarDominio(email.value)) {
                        // alert("Por favor, introduce un correo electrónico con un dominio válido.");
                        erroremail.style.display = "block";
                        document.getElementById("email").classList.add("is-invalid");
                        document.getElementById("email").classList.remove("is-valid");
                        // email.value = ""; // Limpiar el campo si el dominio no es válido
                    }
                });

                function validarDominio(email) {
                    var dominioValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    return dominioValido;
                }


            });


            const prefijosLongitud = {
                "+34": 9, // España
                "+49": 11, // Alemania
                "+33": 9, // Francia
                "+39": 11, // Italia
                "+44": 10, // Reino Unido
                "+7": 10, // Rusia
                "+380": 12, // Ucrania
                "+48": 9, // Polonia
                "+40": 10, // Rumania
                "+31": 9, // Países Bajos
                "+32": 9, // Bélgica
                "+30": 10, // Grecia
                "+351": 9, // Portugal
                "+46": 9, // Suecia
                "+47": 8, // Noruega
                "+1": 10, // Estados Unidos y Canadá
                "+52": 10, // México
                "+55": 11, // Brasil
                "+54": 10, // Argentina
                "+57": 10, // Colombia
                "+56": 9, // Chile
                "+58": 10, // Venezuela
                "+51": 9, // Perú
                "+593": 10, // Ecuador
                "+53": 8, // Cuba
                "+591": 8, // Bolivia
                "+506": 8, // Costa Rica
                "+507": 8, // Panamá
                "+598": 8, // Uruguay
                "+86": 11, // China
                "+91": 10, // India
                "+81": 10, // Japón
                "+82": 10, // Corea del Sur
                "+62": 12, // Indonesia
                "+90": 10, // Turquía
                "+63": 10, // Filipinas
                "+66": 9, // Tailandia
                "+84": 10, // Vietnam
                "+972": 10, // Israel
                "+60": 11, // Malasia
                "+65": 8, // Singapur
                "+92": 11, // Pakistán
                "+880": 13, // Bangladés
                "+966": 13, // Arabia Saudita
                "+20": 11, // Egipto
                "+27": 10, // Sudáfrica
                "+234": 11, // Nigeria
                "+254": 11, // Kenia
                "+212": 10, // Marruecos
                "+213": 10, // Argelia
                "+256": 11, // Uganda
                "+233": 10, // Ghana
                "+237": 9, // Camerún
                "+225": 10, // Costa de Marfil
                "+221": 9, // Senegal
                "+255": 11, // Tanzania
                "+249": 11, // Sudán
                "+218": 10, // Libia
                "+216": 8, // Túnez
                "+61": 9, // Australia
                "+64": 10, // Nueva Zelanda
                "+679": 7, // Fiji
                "+675": 8, // Papúa Nueva Guinea
                "+676": 8, // Tonga
                "+98": 10, // Irán
                "+964": 10, // Iraq
                "+962": 10, // Jordania
                "+961": 8, // Líbano
                "+965": 8, // Kuwait
                "+971": 9, // Emiratos Árabes Unidos
                "+968": 8, // Omán
                "+974": 8, // Catar
                "+973": 8, // Bahrein
                "+967": 9 // Yemen
            };

            function habilitarTelefono() {
                var prefijo = document.getElementById("prefijo").value;
                var telefonoInput = document.getElementById("num_telf");

                // Verificar si el prefijo seleccionado está en el objeto prefijosLongitud
                if (prefijo in prefijosLongitud) {

                    telefonoInput.disabled = false;
                    telefonoInput.maxLength = prefijosLongitud[prefijo];
                    // telefonoInput.value = "";
                    verificarLongitud();
                    // Establecer la longitud máxima del teléfono
                }
            }

            // Event listener para el cambio en el prefijo
            document.getElementById("prefijo").addEventListener("change", habilitarTelefono);

            function verificarLongitud() {
                const telefonoInput = document.getElementById('num_telf');
                telefonoInput.addEventListener("blur", function() {
                    const telefono = telefonoInput.value;
                    const prefijo = document.getElementById('prefijo').value;
                    const longitudEsperada = prefijosLongitud[prefijo];
                    const errorTelf = document.getElementById('error-telf');

                    if (telefono === "") {
                        errorTelf.style.display = 'block';
                        telefonoInput.classList.remove('is-valid');
                        telefonoInput.classList.add('is-invalid');
                    } else if (telefono.length === longitudEsperada) {
                        errorTelf.style.display = 'none';
                        telefonoInput.classList.remove('is-invalid');
                        telefonoInput.classList.add('is-valid');
                    } else {
                        errorTelf.style.display = 'block';
                        telefonoInput.classList.remove('is-valid');
                        telefonoInput.classList.add('is-invalid');
                    }
                });
            }



            var prefijo = document.getElementById("prefijo");
            // Crear una nueva solicitud XMLHttpRequest
            var xhr2 = new XMLHttpRequest();
            xhr2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Parsear la respuesta JSON
                    var data = JSON.parse(this.responseText);
                    // Iterar sobre los datos y agregar opciones al select
                    data.forEach(prefijos => {
                        var option = document.createElement("option");
                        option.value = prefijos.prefijo;
                        option.textContent = prefijos.pais + " (" + prefijos.prefijo + ")";
                        prefijo.appendChild(option);
                    });
                }
            };

            // Abrir y enviar la solicitud
            xhr2.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/prefijo", true);
            xhr2.send();
        </script>
    @endpush
