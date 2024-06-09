var idParking = ""; // Declarar idParking de forma global
var checkbox;
var allres;
// Obtener referencia al input de búsqueda
var inputFiltro = document.getElementById('filtro');
var inputFecha = document.getElementById('filtro_fecha');

function filtrarReservas() {
    // Obtener el valor del input de búsqueda
    var filtro = inputFiltro.value;
    var filtroFecha = document.getElementById('filtro_fecha').value;
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
            var textonav = document.getElementById("texto-nav");
            var hoy = new Date(); // Obtener la fecha actual
            var dia = hoy.getDate();
            var mes2 = hoy.getMonth() + 1; // Los meses en JavaScript se cuentan desde 0
            if (mes2 < 10) {
                var mes = "0" + mes2;
            }
            var año = hoy.getFullYear();
            var fechaActual = año + '-' + mes + '-' + dia; // Formatear la fecha actual

            console.log("filtroFecha:", filtroFecha);
            console.log("fechaActual:", fechaActual);

            if (!filtroFecha || filtroFecha === fechaActual) {
                if (inputFiltro.value == "") {
                    textonav.innerHTML = "Reservas de hoy";
                    document.getElementById("texto-nav2").innerHTML = "Reservas de hoy";
                } else {
                    textonav.innerHTML = "Reservas";
                    document.getElementById("texto-nav2").innerHTML = "Reservas";
                }
            } else {
                textonav.innerHTML = "Reservas de " + filtroFecha;
                document.getElementById("texto-nav2").innerHTML = "Reservas del " + filtroFecha;
            }
            // La petición fue exitosa, procesar la respuesta
            var data = JSON.parse(xhr.responseText);
            var contenidoReserva = '';

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
                var esHoyEntrada = comparaFechas(new Date(), reserva.fechaEntrada);
                var esHoySalida = comparaFechas(new Date(), reserva.fechaSalida);
                // if (esHoyEntrada && reserva.firma_entrada) {
                var horaMostrar = '';

                if (esHoyEntrada) {
                    horaMostrar = formatoHora(reserva.fechaEntrada.getHours()) + ':' + formatoHora(
                        reserva.fechaEntrada.getMinutes());
                    var tieneFirma = '';
                    if (esHoyEntrada && reserva.firma_entrada) {
                        tieneFirma = '<span class="material-symbols-outlined"> done </span>';
                    }

                    var claseColor = 'green';


                    contenidoReserva += '<div class="reservaCliente" style="background-color: ' +
                        claseColor + ';" id="reserva' + reserva.id +
                        '" onclick="window.location.href = \'/info_res?id_r=' + reserva.id + '\'">';
                    contenidoReserva += '<div class="horasReservas">';
                    contenidoReserva += '<h5 style="float: left;">' + horaMostrar + '</h5>';
                    contenidoReserva += '<p>' + tieneFirma + '</p>';
                    contenidoReserva += '</div>';
                    contenidoReserva += '<h3>' + reserva.matricula + '</h3>';

                    var nombreTrabajador = reserva.trabajador ? reserva.trabajador.nombre :
                        'No asignado';
                    var desH = reserva.trabajador ? 'disabled' : '';

                    contenidoReserva +=
                        '<button type="button" class="btn btn-light" data-toggle="popover" title="Popover Header" onmouseover="">' +
                        nombreTrabajador + '</button>';
                    contenidoReserva += '</div>';
                }
                if (esHoySalida) {
                    horaMostrar = formatoHora(reserva.fechaSalida.getHours()) + ':' + formatoHora(
                        reserva.fechaSalida.getMinutes());
                    var tieneFirma = '';
                    if (esHoySalida && reserva.firma_salida) {
                        tieneFirma = '<span class="material-symbols-outlined"> done </span>';
                    }

                    var claseColor = 'red';


                    contenidoReserva += '<div class="reservaCliente" style="background-color: ' +
                        claseColor + ';" id="reserva' + reserva.id +
                        '" onclick="window.location.href = \'/info_res?id_r=' + reserva.id + '\'">';
                    contenidoReserva += '<div class="horasReservas">';
                    contenidoReserva += '<h5 style="float: left;">' + horaMostrar + '</h5>';
                    contenidoReserva += '<p>' + tieneFirma + '</p>';
                    contenidoReserva += '</div>';
                    contenidoReserva += '<h3>' + reserva.matricula + '</h3>';

                    var nombreTrabajador = reserva.trabajador ? reserva.trabajador.nombre :
                        'No asignado';
                    var desH = reserva.trabajador ? 'disabled' : '';
                    contenidoReserva +=
                        '<button type="button" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="' +
                        nombreTrabajador + '" ' + desH + '>' + nombreTrabajador + '</button>';
                    contenidoReserva += '</div>';
                    console.log(esHoyEntrada);
                }
                if ((esHoyEntrada === false && esHoySalida === false)) {
                    horaMostrar = formatoHora(reserva.fechaSalida.getHours()) + ':' + formatoHora(
                        reserva.fechaSalida.getMinutes());
                    var tieneFirma = '';
                    if (esHoySalida && reserva.firma_salida) {
                        tieneFirma = '<span class="material-symbols-outlined"> done </span>';
                    }

                    var claseColor = 'white; color: black';


                    contenidoReserva += '<div class="reservaCliente" style="background-color: ' +
                        claseColor + ';" id="reserva' + reserva.id +
                        '" onclick="window.location.href = \'/info_res?id_r=' + reserva.id + '\'">';
                    contenidoReserva += '<div class="horasReservas">';
                    // contenidoReserva += '<h5 style="float: left;">' + horaMostrar + '</h5>';
                    contenidoReserva += '<p>' + tieneFirma + '</p>';
                    contenidoReserva += '</div>';
                    contenidoReserva += '<h3>' + reserva.matricula + '</h3>';

                    var nombreTrabajador = reserva.trabajador ? reserva.trabajador.nombre :
                        'No asignado';
                    var desH = reserva.trabajador ? 'disabled' : '';
                    contenidoReserva +=
                        '<button type="button" class="btn btn-light" style="z-index: 2;">' +
                        nombreTrabajador + '</button>';
                    contenidoReserva += '</div>';
                }
                // }
            });

            console.log('Total de vueltas: ' + data.reservas.length);
            document.getElementById('texto-nav').innerHTML += " (" + data.reservas.length + ")";

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
    console.log(idParking);
    xhr.send("filtro=" + encodeURIComponent(filtro) + "&filtro_fecha=" + encodeURIComponent(filtroFecha) +
        "&parking=" + encodeURIComponent(idParking) + "&asignado=" + encodeURIComponent(checkbox));
}
var asignado = document.getElementById('asignado');
allres = document.getElementById('pendiente');

// Agregar un event listener para el evento 'keydown' en el input de búsqueda
inputFiltro.addEventListener('keydown', function(event) {
    // Verificar si la tecla presionada es "Enter" (código 13)
    if (event.keyCode === 13) {
        // Ejecutar la función filtrarReservas()
        filtrarReservas();
    }
});
// Agregar un event listener para el evento 'keydown' en el input de búsqueda
inputFecha.addEventListener('blur', function(event) {
    // Verificar si la tecla presionada es "Enter" (código 13)
    filtrarReservas();
});

function checkboxstatus() {
    // Verificar si la tecla presionada es "Enter" (código 13)
    if (asignado.checked) {
        console.log('Checkbox is checked!');
        checkbox = true;
        // Código adicional para cuando el checkbox está activado
    } else {
        console.log('Checkbox is unchecked!');
        checkbox = false;
        // Código adicional para cuando el checkbox está desactivado
    }
    filtrarReservas();
}

function checkboxreservas() {
    // Verificar si la tecla presionada es "Enter" (código 13)
    if (allres.checked) {
        console.log('Checkbox is checked!');
        allres = true;
        // Código adicional para cuando el checkbox está activado
    } else {
        console.log('Checkbox is unchecked!');
        allres = false;
        // Código adicional para cuando el checkbox está desactivado
    }
    filtrarReservas();
}

asignado.addEventListener('change', function(event) {
    checkboxstatus();
});
allres.addEventListener('change', function(event) {
    checkboxreservas();
});

function filtroUbi() {
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
                html +=
                    '<input style="background-color: grey;" class="form-check-input" type="radio" name="flexRadioDefault" value="' +
                    parking.id + '" id="parking' + parking.id + '">';
                html += '<label class="form-check-label" for="parking' + parking.id + '">' + parking
                    .nombre + '</label>';
                html += '</div>';
            });

            // Actualizar el contenido del elemento 'ubicaciones'
            document.getElementById('ubicaciones').innerHTML = html;

            // Agregar event listeners a los checkboxes
            parkings.forEach(function(parking) {
                var checkbox = document.getElementById('parking' + parking.id);
                checkbox.addEventListener('change', function() {
                    idParking = parking.id;
                    filtrarReservas
                        (); // Llamar a filtrarReservas() con el valor del checkbox como argumento
                });
            });
        }
    };

    // Configurar el callback para manejar errores de red
    xhr.onerror = function() {
        console.error('Error de red al realizar la petición.');
    };

    // Enviar la petición
    xhr.send(); // Asegúrate de codificar el filtro correctamente
}

function Selects() {
    var radiosUbicaciones = document.querySelectorAll('input[name="flexRadioDefault"]');

    // Recorrer los radios y deseleccionarlos
    radiosUbicaciones.forEach(function(radio) {
        radio.checked = false;
    });
    idParking = "";

    // Llamar a la función de filtrarReservas para refrescar la lista de reservas
    checkboxstatus();
}
document.getElementById('deseleccionarUbicaciones').addEventListener('click', function() {
    // Obtener todos los radios de ubicación
    Selects();
});

function borrarFiltro() {
    // Obtener todos los radios de ubicación
    var fecha = document.getElementById("filtro_fecha");
    fecha.value = "";
    asignado.checked = false;

    // Llamar a la función de filtrarReservas para refrescar la lista de reservas
    Selects();
}

function Checked() {
    if (asignado.checked == true) {
        asignado.checked = false;
    } else {
        asignado.checked = true;
    }
    checkboxstatus();
}

function CheckedRes() {
    if (allres.checked == true) {
        allres.checked = false;
    } else {
        allres.checked = true;
    }
    checkboxreservas();
}

filtroUbi();
filtrarReservas();
// Función para formatear la hora en dos dígitos
function formatoHora(hora) {
    return hora.toString().padStart(2, '0');
}

// Función para comparar fechas
function comparaFechas(fecha1, fecha2) {
    return fecha1.toDateString() === fecha2.toDateString();
}
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// function googleTranslateElementInit() {
//     new google.translate.TranslateElement({
//         pageLanguage: 'es',
//         includedLanguages: 'ca,eu,en,fr,it,pt',
//         // layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
//         // gaTrack: true
//     }, 'google_translate_element');
// }