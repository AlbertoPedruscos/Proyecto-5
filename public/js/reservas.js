
ListarEmpresas('');

function ListarEmpresas(nombre) {
    var resultado = document.getElementById('resultado');
    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('nombre', nombre);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/listarreservas');
    ajax.onload = function () {
        if (ajax.status == 200) {
            var json = JSON.parse(ajax.responseText);
            // console.log(json);

            // tabla reservas
            let tabla = '';
            json.forEach(function (reserva) {
                var trabajador = reserva.trabajador ? reserva.trabajador : 'No asignado';
                var plaza = reserva.plaza ? reserva.plaza : 'No escogido';
                var parking = reserva.parking ? reserva.parking : 'No escogido';
                var firma_entrada = reserva.firma_entrada ? reserva.firma_entrada : 'No firmado';
                var firma_salida = reserva.firma_salida ? reserva.firma_salida : 'No firmado';
                let str = '<div style="border:solid 2px; margin: 10px; padding:10px; float:left; ">';
                // str += "<form action='' method='post' id='frmeditar'>";

                str += "<p> <strong>Trabajador: </strong>" + trabajador + "</p>";
                str += "<p> <strong>Plaza: </strong>" + plaza + "</p>";
                str += "<p> <strong>Parking: </strong>" + parking + "</p>";
                str += "<p> <strong>Cliente: </strong>" + reserva.nom_cliente + "</p>";
                str += "<p> <strong>Matricula: </strong>" + reserva.matricula + "</p>";
                str += "<p> <strong>Marca: </strong>" + reserva.marca + "</p>";
                str += "<p> <strong>Modelo: </strong>" + reserva.modelo + "</p>";
                str += "<p> <strong>Color: </strong>" + reserva.color + "</p>";
                str += "<p> <strong>Contacto: </strong>" + reserva.num_telf + "</p>";
                str += "<p> <strong>Email: </strong>" + reserva.email + "</p>";
                str += "<p> <strong>Punto recogida: </strong>" + reserva.ubicacion_entrada + "</p>";
                str += "<p> <strong>Punto entrega: </strong>" + reserva.ubicacion_salida + "</p>";
                str += "<p> <strong>Fecha entrada: </strong>" + reserva.fecha_entrada + "</p>";
                str += "<p> <strong>Firma entrada: </strong>" + firma_entrada + "</p>";
                str += "<p> <strong>Fecba entrega: </strong>" + reserva.fecha_salida + "</p>";
                str += "<p> <strong>Firma salida: </strong>" + firma_salida + "</p>";

                // str += "</form>";
                str += "</div>";
                tabla += str;
            });
            resultado.innerHTML = tabla;
        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}
