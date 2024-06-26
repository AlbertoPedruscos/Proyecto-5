@php
// ini_set('memory_limit', '4048M');
use App\Models\tbl_ubicaciones;
use Illuminate\Support\Facades\DB;

$ubicacion = DB::table('tbl_ubicaciones')
    ->join('tbl_empresas', 'tbl_ubicaciones.empresa', '=', 'tbl_empresas.id')
    ->select('tbl_ubicaciones.*', 'tbl_empresas.nombre as nombre_empresa')
    ->get();
@endphp
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
            <li><a href="/contactar">Contáctanos</a></li>
            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
        </ul>
        <select name="" id="selectE">
            <option value="">Más opciones</option>
            <option value="/contactar">Contáctanos</option>
            <option value="{{ route('login') }}">Iniciar sesión</option>
        </select>
    </nav>

    <div id="formulario">
        <div id="cont-form">
            <h1>Haga su reserva</h1>
            <form action="" method="post" id="FrmReserva" class="form-floating">
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
                                <input type="text" class="form-control" name="matricula" id="matricula">
                                <label for="floatingInputValue">Matrícula</label>
                            </div>
                            <div class="invalid-feedback" id="error-matricula" style="display: none;">
                                Formato de matrícula incorrecto.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="email" class="form-control" name="email" id="email">
                            <label for="floatingInputGrid">Email</label>
                        </div>
                        <div class="invalid-feedback" id="error-email" style="display: none;">
                            Formato de email incorrecto.
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select class="form-select" name="prefijo" id="prefijo"
                                    aria-label="Floating label select example">
                                    <option selected disabled>Seleccione su prefijo</option>
                                </select>
                                <label for="floatingSelect">Prefijo</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="num_telf" id="num_telf">
                                <label for="floatingInputValue">Teléfono</label>
                            </div>
                            <div class="invalid-feedback" id="error-telf" style="display: none;">
                                Formato de teléfono incorrecto.
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" name="cochesSelect" id="cochesSelect"
                                    aria-label="Floating label select example">
                                    <option value="0" selected disabled>Seleccione su vehículo...</option>
                                </select>
                                <label for="floatingSelect">Vehículo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="modelo" id="modelo">
                                <label for="floatingInputValue">Modelo</label>
                            </div>
                            <div class="invalid-feedback" id="error-modelo" style="display: none;">
                                El campo "modelo" no puede estar vacío.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="color" id="colorInput">
                                <label for="colorInput">Color</label>
                                {{-- ESTE NO ES OBLIGATORIO --}}
                            </div>
                            <div id="colorValidationMessage" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <select class="form-select" name="ubicacion_entrada" id="ubicacion_entrada" aria-label="Floating label select example">
                                    <option selected disabled>Seleccione el punto de entrega...</option>
                                    @foreach ($ubicacion as $ubicaciones)
                                        <option value="{{ $ubicaciones->id }}">{{ $ubicaciones->nombre_sitio }} - {{ $ubicaciones->nombre_empresa }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Punto de entrega</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select class="form-select" name="ubicacion_salida" id="ubicacion_salida" aria-label="Floating label select example">
                                    <option selected disabled>Seleccione el punto de recogida...</option>
                                    @foreach ($ubicacion as $ubicaciones)
                                        <option value="{{ $ubicaciones->id }}">{{ $ubicaciones->nombre_sitio }} - {{ $ubicaciones->nombre_empresa }}</option>
                                    @endforeach
                                </select>                                
                                <label for="floatingSelect">Punto de recogida</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Entrega</span>
                        <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Recogida</span>
                        <input type="datetime-local" class="form-control" id="fecha_salida" name="fecha_salida" disabled>
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
                    <button type="button" id="form-btn" class="btn btn-dark" onclick="reservarNuevo()" disabled>Enviar</button>
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
    </div>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        {{-- <script src="https://js.stripe.com/v3/"></script> --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ubicacionEntrada = document.getElementById('ubicacion_entrada');
                var ubicacionSalida = document.getElementById('ubicacion_salida');

                ubicacionEntrada.addEventListener('change', function() {
                    var selectedEmpresa = this.options[this.selectedIndex].text.split(' - ')[1];
                    filterUbicacionSalida(selectedEmpresa);
                });

                function filterUbicacionSalida(selectedEmpresa) {
                    var options = ubicacionSalida.options;
                    for (var i = 1; i < options.length; i++) {
                        var empresa = options[i].text.split(' - ')[1];
                        if (empresa === selectedEmpresa || selectedEmpresa === 'Seleccione el punto de entrega...') {
                            options[i].style.display = '';
                        } else {
                            options[i].style.display = 'none';
                        }
                    }
                    ubicacionSalida.selectedIndex = 0;
                }
            });
            document.getElementById('selectE').addEventListener('change', function() {
                const url = this.value;
                if (url && url !== "") {
                    console.log("URL a redirigir:", url);
                    window.location.href = url;
                }
            });
        //     // Función para verificar si todos los inputs tienen texto
        //     function verificarInputs() {
        //         var inputs = document.querySelectorAll('input[type="text"], input[type="email"], select');
        //         var todosConTexto = true;
        //         var checkboxMarcado = document.getElementById('invalidCheck2').checked;

        //         inputs.forEach(function(input) {
        //             if (input.value.trim() === '') {
        //                 todosConTexto = false;
        //             }
        //         });

        //         // Verificar que el checkbox esté marcado
        //         if (!checkboxMarcado) {
        //             todosConTexto = false;
        //         }

        //         var botonEnviar = document.getElementById('form-btn-pagos');
        //         if (todosConTexto) {
        //             botonEnviar.disabled = false;
        //         } else {
        //             botonEnviar.disabled = true;
        //         }
        //     }


        //     // Llamar a la función cuando cambie el contenido de un input
        //     var inputs = document.querySelectorAll('input[type="text"], input[type="email"], select');
        //     inputs.forEach(function(input) {
        //         input.addEventListener('input', verificarInputs);
        //     });
        //     function pagos() {
        //         Swal.fire({
        //             title: 'Formulario de Pago',
        //             html: `
        //                 <form id="payment-form">
        //                     @csrf
        //                     <!-- Agrega los campos necesarios para el formulario de pago aquí -->
        //                     <div class="form-group">
        //                         <input type="text" class="form-control" id="card_number" required placeholder="Número de Tarjeta" maxlength="19">
        //                     </div>
        //                     <div class="form-group">
        //                         <input type="text" class="form-control" id="card_expiry" required placeholder="Fecha de Expiración (MM/YY)" maxlength="5">
        //                     </div>
        //                     <div class="form-group">
        //                         <input type="text" class="form-control" id="card_cvc" required placeholder="CVC" maxlength="3">
        //                     </div>
        //                 </form>
        //             `,
        //             showCancelButton: true,
        //             confirmButtonText: 'Pagar',
        //             preConfirm: () => {
        //                 // Recolecta los datos del formulario
        //                 const formData = new FormData(document.getElementById('payment-form'));
        //                 const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Corrección aquí
        //                 const fechaEntrega = document.getElementById('fecha_entrada').value;
        //                 const fechaRecogida = document.getElementById('fecha_salida').value;
        //                 formData.append('fechaEntrega', fechaEntrega);
        //                 formData.append('fechaRecogida', fechaRecogida);
        //                 formData.append('_token', csrfToken);

        //                 // Crea una nueva solicitud XMLHttpRequest
        //                 const xhr = new XMLHttpRequest();

        //                 // Configura la solicitud
        //                 xhr.open('POST', '/procesar-pago');
        //                 // xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        //                 // Maneja el evento de carga
        //                 xhr.onload = function () {
        //                     if (xhr.status === 200) {
        //                         // Si la solicitud se completa correctamente, muestra un mensaje de éxito
        //                         Swal.fire('¡Pago exitoso!', 'El pago ha sido procesado correctamente.', 'success');
        //                         console.log(xhr.responseText);
        //                         var botonEnviar = document.getElementById('form-btn');
        //                         botonEnviar.disabled = false;
        //                     } else {
        //                         // Si hay un error en la solicitud, muestra un mensaje de error
        //                         Swal.fire('¡Error!', 'Hubo un problema al procesar el pago.', 'error');
        //                         console.log(xhr.responseText);
        //                     }
        //                 };

        //                 // Maneja el evento de error
        //                 xhr.onerror = function () {
        //                     // Si hay un error en la solicitud, muestra un mensaje de error
        //                     Swal.fire('¡Error!', 'Hubo un problema al procesar el pago.', 'error');
        //                     console.log(xhr.responseText);
        //                 };

        //                 // Envía la solicitud con los datos del formulario
        //                 xhr.send(formData);
        //             }
        //         });

        //     // Formatear el número de tarjeta al agregar espacios cada 4 dígitos
        //     document.getElementById('card_number').addEventListener('input', function () {
        //         let value = this.value.replace(/\D/g, ''); // Eliminar caracteres que no sean dígitos
        //         value = value.replace(/(\d{4})(?=\d)/g, '$1 '); // Agregar espacio cada 4 dígitos
        //         this.value = value;
        //     });

        //     // Formatear la fecha de expiración al agregar una barra después de los primeros dos dígitos
        //     document.getElementById('card_expiry').addEventListener('input', function () {
        //         let value = this.value.replace(/\D/g, ''); // Eliminar caracteres que no sean dígitos
        //         if (value.length > 2) {
        //             value = value.substring(0, 2) + '/' + value.substring(2); // Agregar la barra después de los primeros dos dígitos
        //         }
        //         this.value = value;
        //     });
        // }


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

                // Matricula

                var matriculaInput = document.getElementById("matricula");
                var errormatricula = document.getElementById('error-matricula');

                matriculaInput.addEventListener("blur", function() {
                    var matricula = matriculaInput.value.trim();

                    var valor = matriculaInput.value.toUpperCase(); // Convertir a mayúsculas
                    var regex = /^[A-Z0-9]*$/;
                    matriculaInput.value =
                        valor; // Establecer el valor del campo de entrada con el texto formateado

                    if (!regex.test(valor)) {
                        // Si se ingresa un carácter especial que no sea letra o número, eliminarlo del valor del input
                        matriculaInput.value = valor.replace(/[^A-Z0-9]/g, '');
                    }

                    if (validarMatricula(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaF(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaA(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaU(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaH(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaRU(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaSU(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else if (validarMatriculaH2(matricula)) {
                        // formbtn.disabled = false;
                        errormatricula.style.display = 'none';
                        document.getElementById("matricula").classList.remove("is-invalid");
                        document.getElementById("matricula").classList.add("is-valid");
                    } else {
                        formbtn.disabled = true;
                        errormatricula.style.display = 'block';
                        document.getElementById("matricula").classList.remove("is-valid");
                        document.getElementById("matricula").classList.add("is-invalid");
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



                // TELEFONO
                var num_telf = document.getElementById("num_telf");
                num_telf.addEventListener("input", function() {
                    var numero = num_telf.value.trim();
                    // Reemplazar espacios y letras por una cadena vacía
                    num_telf.value = num_telf.value.replace(/\s/g, '').replace(/[a-zA-Z]/g, '');
                    // Si el número no empieza por 6, limpiar el campo y mostrar un mensaje de error
                    if (numero.charAt(0) !== '6' && numero.charAt(0) !== '9' && numero.charAt(0) !== '7') {
                        num_telf.value = "";
                        formbtn.disabled = true;
                        // mensajeError.style.marginTop = "10px"; // Añadir un margen superior al mensaje de error
                        return;
                    }
                    // Limitar la longitud a 9 caracteres
                    if (numero.length > 9) {
                        num_telf.value = numero.slice(0, 9); // Truncar el número a 9 caracteres
                    }

                });

                var errortelf = document.getElementById('error-telf');
                num_telf.addEventListener("blur", function() {

                    if (!validarNumero(num_telf.value)) {
                        formbtn.disabled = true;
                        document.getElementById("num_telf").classList.add("is-invalid");
                        document.getElementById("num_telf").classList.remove("is-valid");
                        errortelf.style.display = "block";

                    } else {
                        // formbtn.disabled = false;
                        document.getElementById("num_telf").classList.remove("is-invalid");
                        document.getElementById("num_telf").classList.add("is-valid");
                        errortelf.style.display = "none";
                    }
                });

                function validarNumero(numero) {
                    var regex = /^\d{9}$/; // El número debe tener exactamente 9 dígitos
                    return regex.test(numero);
                }

                // Modelo

                var inputModelo = document.getElementById("modelo");
                var errormodelo = document.getElementById('error-modelo');

                inputModelo.addEventListener("blur", function() {
                    validarModelo(this);
                });

                function validarModelo(input) {
                    if (input.value.trim() === '') { // Verificar si el campo está vacío
                        document.getElementById("modelo").classList.remove("is-valid");
                        document.getElementById("modelo").classList.add("is-invalid");
                        errormodelo.style.display = 'block';
                        return false;
                    } else {
                        document.getElementById("modelo").classList.remove("is-invalid");
                        document.getElementById("modelo").classList.add("is-valid");
                        errormodelo.style.display = 'none';
                        return true;
                    }

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
                        input.value =
                            textoFormateado; // Establecer el valor del campo de entrada con el texto formateado
                        // input.style.borderColor = "red"; // Establecer borde rojo ya que la entrada no es válida
                        return false;
                    }
                }

                // FECHA ENTRADA
                var inputFecha = document.getElementById("fecha_entrada");

                inputFecha.addEventListener("input", function() {
                    validarFecha(this);
                });

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
                            var inputSalida = document.getElementById("fecha_salida");
                            inputSalida.disabled = false; // Habilitar el campo de fecha de salida
                            formbtn.disabled = true;
                            return true;
                        } else {
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

                // FECHA SALIDA
                var inputSalida = document.getElementById("fecha_salida");
                var inputEntrada = document.getElementById("fecha_entrada");
                inputSalida.addEventListener("input", function() {
                    validarFechaSalida(this, inputEntrada);
                });

                function validarFechaSalida(inputSalida, inputEntrada) {
                    var fechaSalida = new Date(inputSalida.value);
                    var fechaEntrada = new Date(inputEntrada.value);
                    // Agregar 5 horas (5 * 60 * 60 * 1000 milisegundos) a la fecha de entrada
                    var fechaMinimaPermitidaMS = fechaEntrada.getTime() + (5 * 60 * 60 * 1000);
                    // Comprobar si la fecha de salida es válida y si es al menos 5 horas después de la fecha de entrada
                    if (!isNaN(fechaSalida.getTime()) && fechaSalida >= new Date(fechaMinimaPermitidaMS)) {
                        inputSalida.setCustomValidity(""); // La fecha es válida
                        formbtn.disabled = false;
                        return true;
                    } else {
                        formbtn.disabled = true;
                        return false;
                    }
                }
            });

            // Tipo Coche

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
                        option.value = coche.marca;
                        option.textContent = coche.marca;
                        cochesSelect.appendChild(option);
                    });
                }
            };

            // Abrir y enviar la solicitud
            xhr.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/coches", true);
            xhr.send();

            // Prefijo

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

            var formbtn = document.getElementById('form-btn');

            function reservarNuevo() {
                var form = document.getElementById('FrmReserva');
                var formdata = new FormData(form);

                var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
                formdata.append('_token', csrfToken);
                formdata.forEach(function(value, key) {
                    console.log(key + ': ' + value);
                });
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
                            icon: 'warning',
                            title: '!Comprueba los campos¡ <br> O <br> Contacta con la empresa',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                };

                ajax.send(formdata);
            }
        </script>
    @endpush
