
ListarEmpresas('');

function ListarEmpresas(nombre) {
    var expirados = document.getElementById('expirados');
    var activos = document.getElementById('activos');
    var nuevos = document.getElementById('nuevos');

    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('nombre', nombre);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/listarreservas');
    ajax.onload = function () {
        if (ajax.status == 200) {
            var json = JSON.parse(ajax.responseText);
            console.log(json);

            // tabla reservas
            let DatosAnteriores = '';
            let DatosActuales = '';
            let DatosPosteriores = '';

            var contador = 0;
            var contador2 = 0;
            var contador3 = 0;

            var fechaActualIni = new Date();
            fechaActualIni.setHours(0);
            fechaActualIni.setMinutes(0);
            fechaActualIni.setSeconds(0);

            var fechaActualFin = new Date();
            fechaActualFin.setHours(23);
            fechaActualFin.setMinutes(60);
            fechaActualFin.setSeconds(60);
            json.forEach(function (reserva) {
                var strexpirados = "";
                var stractivos = "";
                var strnuevos = "";

                var trabajador = reserva.trabajador ? reserva.trabajador : 'No asignado';
                var plaza = reserva.plaza ? reserva.plaza : 'No escogido';
                var parking = reserva.parking ? reserva.parking : 'No escogido';
                var firma_entrada = reserva.firma_entrada ? reserva.firma_entrada : 'No firmado';
                var firma_salida = reserva.firma_salida ? reserva.firma_salida : 'No firmado';

                let fechaEntrada = new Date(reserva.fecha_entrada);
                let fechaSalida = new Date(reserva.fecha_salida);


                // console.log("El contador es: " + fechaSalida);
                console.log("El fechaActual es: " + fechaActualFin);
                if (fechaEntrada > fechaActualIni && fechaSalida > fechaActualFin) {
                    contador++;
                    strexpirados += "<div style='border: 1px solid'>";
                    strexpirados += "<p> posterior <strong>Trabajador: </strong>" + trabajador + "</p>";
                    // strexpirados += "<p> <strong>Plaza: </strong>" + plaza + "</p>";
                    // strexpirados += "<p> <strong>Parking: </strong>" + parking + "</p>";
                    // strexpirados += "<p> <strong>Cliente: </strong>" + reserva.nom_cliente + "</p>";
                    // strexpirados += "<p> <strong>Matrícula: </strong>" + reserva.matricula + "</p>";
                    // strexpirados += "<p> <strong>Marca: </strong>" + reserva.marca + "</p>";
                    strexpirados += "<p> <strong>Modelo: </strong>" + reserva.modelo + "</p>";
                    strexpirados += "<p> <strong>Color: </strong>" + reserva.color + "</p>";
                    strexpirados += "<p> <strong>Contacto: </strong>" + reserva.num_telf + "</p>";
                    strexpirados += "<p> <strong>Email: </strong>" + reserva.email + "</p>";
                    strexpirados += "<p> <strong>Punto recogida: </strong>" + reserva.ubicacion_entrada + "</p>";
                    strexpirados += "<p> <strong>Punto entrega: </strong>" + reserva.ubicacion_salida + "</p>";
                    strexpirados += "<p> <strong>Fecha entrada: </strong>" + reserva.fecha_entrada + "</p>";
                    strexpirados += "<p> <strong>Firma entrada: </strong>" + firma_entrada + "</p>";
                    strexpirados += "<p> <strong>Fecha entrega: </strong>" + reserva.fecha_salida + "</p>";
                    strexpirados += "<p> <strong>Firma salida: </strong>" + firma_salida + "</p>";
                    strexpirados += "</div>";
                } else if (fechaActualIni > fechaEntrada && fechaActualFin > fechaSalida) {
                    contador2++;
                    stractivos += "<div style='border: 1px solid'>";
                    stractivos += "<p> pasada <strong>Trabajador: </strong>" + trabajador + "</p>";
                    // stractivos += "<p> <strong>Plaza: </strong>" + plaza + "</p>";
                    // stractivos += "<p> <strong>Parking: </strong>" + parking + "</p>";
                    // stractivos += "<p> <strong>Cliente: </strong>" + reserva.nom_cliente + "</p>";
                    // stractivos += "<p> <strong>Matrícula: </strong>" + reserva.matricula + "</p>";
                    stractivos += "<p> <strong>Marca: </strong>" + reserva.marca + "</p>";
                    stractivos += "<p> <strong>Modelo: </strong>" + reserva.modelo + "</p>";
                    stractivos += "<p> <strong>Color: </strong>" + reserva.color + "</p>";
                    stractivos += "<p> <strong>Contacto: </strong>" + reserva.num_telf + "</p>";
                    stractivos += "<p> <strong>Email: </strong>" + reserva.email + "</p>";
                    stractivos += "<p> <strong>Punto recogida: </strong>" + reserva.ubicacion_entrada + "</p>";
                    stractivos += "<p> <strong>Punto entrega: </strong>" + reserva.ubicacion_salida + "</p>";
                    stractivos += "<p> <strong>Fecha entrada: </strong>" + reserva.fecha_entrada + "</p>";
                    stractivos += "<p> <strong>Firma entrada: </strong>" + firma_entrada + "</p>";
                    stractivos += "<p> <strong>Fecha entrega: </strong>" + reserva.fecha_salida + "</p>";
                    stractivos += "<p> <strong>Firma salida: </strong>" + firma_salida + "</p>";
                    stractivos += "</div>";
                } else {
                    contador3++;
                    strnuevos += "<div style='border: 1px solid'>";
                    strnuevos += "<p> actual <strong>Trabajador: </strong>" + trabajador + "</p>";
                    strnuevos += "<p> <strong>Plaza: </strong>" + plaza + "</p>";
                    // strnuevos += "<p> <strong>Parking: </strong>" + parking + "</p>";
                    // strnuevos += "<p> <strong>Cliente: </strong>" + reserva.nom_cliente + "</p>";
                    // strnuevos += "<p> <strong>Matrícula: </strong>" + reserva.matricula + "</p>";
                    // strnuevos += "<p> <strong>Marca: </strong>" + reserva.marca + "</p>";
                    strnuevos += "<p> <strong>Modelo: </strong>" + reserva.modelo + "</p>";
                    strnuevos += "<p> <strong>Color: </strong>" + reserva.color + "</p>";
                    strnuevos += "<p> <strong>Contacto: </strong>" + reserva.num_telf + "</p>";
                    strnuevos += "<p> <strong>Email: </strong>" + reserva.email + "</p>";
                    strnuevos += "<p> <strong>Punto recogida: </strong>" + reserva.ubicacion_entrada + "</p>";
                    strnuevos += "<p> <strong>Punto entrega: </strong>" + reserva.ubicacion_salida + "</p>";
                    strnuevos += "<p> <strong>Fecha entrada: </strong>" + reserva.fecha_entrada + "</p>";
                    strnuevos += "<p> <strong>Firma entrada: </strong>" + firma_entrada + "</p>";
                    strnuevos += "<p> <strong>Fecha entrega: </strong>" + reserva.fecha_salida + "</p>";
                    strnuevos += "<p> <strong>Firma salida: </strong>" + firma_salida + "</p>";
                    strnuevos += "</div>";
                }

                DatosAnteriores += strexpirados;
                DatosActuales += stractivos;
                DatosPosteriores += strnuevos;
            });

            console.log("El contador es: " + contador);
            console.log("El contador 2 es: " + contador2);
            console.log("El contador 3 es: " + contador3);
            expirados.innerHTML = DatosAnteriores;
            activos.innerHTML = DatosActuales;
            nuevos.innerHTML = DatosPosteriores;

        } else {
            expirados.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}
