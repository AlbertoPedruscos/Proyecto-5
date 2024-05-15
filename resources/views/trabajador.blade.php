@if (session('id'))
    <!DOCTYPE html>
    <html lang="en">

    <head>
        {{-- FUENTE --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
        {{-- ICONOS --}}
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        {{-- BOOSTRAPP --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="{{ asset('./css/reservas.css') }}">
        {{-- TOKEN --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reservas de hoy</title>
    </head>

    <body>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">Reservas de hoy</a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <a class="navbar-brand" href="logout" class="dropdown-item" style="color: black;">Cerrar sesión</a>
                            <a class="navbar-brand" href="/chatG" class="dropdown-item" style="color: black;">Chat</a>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="filtro">
            <div class="iconoFiltro">
                <div class="accordion-item" style="padding-left: 1.5vh;">
                    <h2 class="accordion-header">
                        <p class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <span class="material-symbols-outlined" style="background-color: transparent;">
                                filter_alt
                            </span>
                        </p>
                    </h2>
                </div>
            </div>
            <div class="inputFiltro">
                <input type="search" name="filtro" id="filtro" class="form-control" style="float: left;">
                <span class="material-symbols-outlined" onclick="filtrarReservas()">
                    search
                </span>
            </div>
        </div>
        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Ubicación
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="ubicaciones">
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Accordion Item #2
                        </button>
                      </h2>
                      <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Accordion Item #3
                        </button>
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
        <div class="reservas" id="reservas">

        </div>

        <script type="text/javascript">
            // Obtener referencia al input de búsqueda
            var inputFiltro = document.getElementById('filtro');

            function filtrarReservas() {
                // document.getElementById('reservas').innerHTML = "";
                // Obtener el valor del input de búsqueda
                var filtro = inputFiltro.value;
                // Obtener el token CSRF desde una etiqueta meta
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Configurar la petición Ajax incluyendo el token CSRF
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('mostrarR') }}", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Establecer el tipo de contenido
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Configurar el token CSRF en la cabecera de la solicitud


                // Configurar el callback cuando la petición haya sido completada
                xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // La petición fue exitosa, procesar la respuesta
                    var data = JSON.parse(xhr.responseText);

                    // Construir la tabla con los datos recibidos
                    // var tabla = '<table class="table"><thead><tr><th>ID</th><th>Nombre Cliente</th><th>Teléfono</th><th>Email</th></tr></thead><tbody>';
                      var contenidoReserva;
                    // Iterar sobre los datos de las reservas y agregar filas a la tabla
                    // data.reservas.forEach(function(reserva) {
                    //     tabla += '<tr><td>' + reserva.id + '</td><td>' + reserva.nom_cliente + '</td><td>' + reserva.num_telf + '</td><td>' + reserva.email + '</td></tr>';
                    // });
                    var contadorVueltas = 0;
                    // Primero, convertimos las fechas de entrada y salida en objetos Date y añadimos la propiedad hora para cada reserva
                    data.reservas.forEach(function(reserva) {
                        reserva.fechaEntrada = new Date(reserva.fecha_entrada);
                        reserva.fechaSalida = new Date(reserva.fecha_salida);

                        // Calculamos la hora basada en la fecha de entrada o salida, dependiendo de cuál sea más temprana
                        reserva.hora = Math.min(reserva.fechaEntrada.getTime(), reserva.fechaSalida.getTime());
                    });

                    // Luego, ordenamos las reservas por la propiedad hora
                    data.reservas.sort(function(a, b) {
                        return a.hora - b.hora;
                    });

                    // Finalmente, recorremos las reservas para crear el contenido
                    data.reservas.forEach(function(reserva) {
                        contadorVueltas++;

                        var esHoyEntrada = comparaFechas(new Date(), reserva.fechaEntrada);
                        var esHoySalida = comparaFechas(new Date(), reserva.fechaSalida);
                        
                        var horaMostrar = '';

                        if (esHoyEntrada) {
                            horaMostrar = formatoHora(reserva.fechaEntrada.getHours()) + ':' + formatoHora(reserva.fechaEntrada.getMinutes());
                        } else if (esHoySalida) {
                            horaMostrar = formatoHora(reserva.fechaSalida.getHours()) + ':' + formatoHora(reserva.fechaSalida.getMinutes());
                        }

                        var tieneFirma = '';
                        if (esHoyEntrada && reserva.firma_entrada) {
                            tieneFirma = '<span class="material-symbols-outlined"> done </span>';
                        } else if (esHoySalida && reserva.firma_salida) {
                            tieneFirma = '<span class="material-symbols-outlined"> done </span>';
                        }

                        var claseColor = esHoyEntrada ? 'green' : (esHoySalida ? 'red' : 'white; color: black');

                        contenidoReserva += '<div class="reservaCliente" style="background-color: ' + claseColor + ';" id="reserva' + reserva.id + '" onclick="window.location.href = \'/info_res?id_r=' + reserva.id + '\'">';
                        contenidoReserva += '<div class="horasReservas">';
                        contenidoReserva += '<h5 style="float: left;">' + horaMostrar + '</h5>';
                        contenidoReserva += '<p>' + tieneFirma + '</p>';
                        contenidoReserva += '</div>';
                        contenidoReserva += '<h3>' + reserva.matricula + '</h3>';
                        
                        var nombreTrabajador = reserva.trabajador ? reserva.trabajador.nombre : 'No asignado';
                        var desH = reserva.trabajador ? 'disabled' : '';
                        
                        contenidoReserva += '<button type="button" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="' + nombreTrabajador + '" ' + desH + '>' + nombreTrabajador + '</button>';
                        contenidoReserva += '</div>';
                    });

                    // Agregar event listeners a los checkboxes
                    parkings.forEach(function(parking) {
                        var checkbox = document.getElementById('parking' + parking.id);
                        checkbox.addEventListener('change', function() {
                            filtrarReservas(parking.id); // Llamar a filtrarReservas() con el valor del checkbox como argumento
                        });
                    });

                    function comparaFechas(fecha1, fecha2) {
                        return fecha1.toDateString() === fecha2.toDateString();
                    }

                    function formatoHora(hora) {
                        return (hora < 10) ? '0' + hora : hora;
                    }



                    console.log('Total de vueltas: ' + contadorVueltas);

                    // Cerrar la tabla

                    // Actualizar el contenido de la sección de reservas con la tabla construida
                    document.getElementById('reservas').innerHTML = contenidoReserva;
                } else {
                    // Ocurrió un error al hacer la petición
                    console.error('Error al realizar la petición:', xhr.status);
                }
            };

                // Configurar el callback para manejar errores de red
                xhr.onerror = function() {
                    console.error('Error de red al realizar la petición.');
                };

                // Enviar la petición
                xhr.send("filtro=" + encodeURIComponent(filtro) + "&parking=" + idParking); // Asegúrate de codificar el filtro correctamente
            }

            //   // Agregar un event listener para el evento 'input'
            //   // inputFiltro.addEventListener('input', function() {
            //   //   filtrarReservas();
            //   // });
            //   // Agregar un event listener para el evento 'keydown' en el input de búsqueda
            inputFiltro.addEventListener('keydown', function(event) {
                // Verificar si la tecla presionada es "Enter" (código 13)
                if (event.keyCode === 13) {
                    // Ejecutar la función filtrarReservas()
                    filtrarReservas();
                }
            });
            function filtroUbi() {
                // document.getElementById('reservas').innerHTML = "";
                // Obtener el valor del input de búsqueda
                // Obtener el token CSRF desde una etiqueta meta
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Configurar la petición Ajax incluyendo el token CSRF
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('filtroUbi') }}", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Establecer el tipo de contenido
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Configurar el token CSRF en la cabecera de la solicitud


                // Configurar el callback cuando la petición haya sido completada
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        var data = JSON.parse(xhr.responseText);
                        var parkings = data.parkings;

                        // Construir el HTML para los parkings
                        var html = '';
                        parkings.forEach(function(parking) {
                            html += '<div class="form-check">';
                            html += '<input class="form-check-input" type="checkbox" value="' + parking.id + '" id="parking' + parking.id + '">';
                            html += '<label class="form-check-label" for="parking' + parking.id + '">' + parking.nombre + '</label>';
                            html += '</div>';
                        });

                        // Actualizar el contenido del elemento 'ubicaciones'
                        document.getElementById('ubicaciones').innerHTML = html;
                    }
                };

                // Configurar el callback para manejar errores de red
                xhr.onerror = function() {
                    console.error('Error de red al realizar la petición.');
                };

                // Enviar la petición
                xhr.send(); // Asegúrate de codificar el filtro correctamente
                }
            filtroUbi();
            filtrarReservas();
        </script>
    </body>

    </html>
@else
    {{-- Establecer el mensaje de error --}}
    @php
        session()->flash('error', 'Debes iniciar sesión para acceder a esta página');
    @endphp

    {{-- Redireccionar al usuario a la página de inicio de sesión --}}
    <script>
        window.location = "{{ route('login') }}";
    </script>

    @csrf
    <script>
        var csrfToken = "{{ csrf_token() }}";
    </script>
@endif
