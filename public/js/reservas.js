
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
            // var reservas = json.reservas;
            var roles = json.roles;
            var reservas = json.reservas;

            console.log(reservas);

            // tabla reservas
            let tabla = '';
            reservas.forEach(function (reserva) {
                // var trabajador = reserva.trabajador ? reserva.trabajador : 'No asignado';
                let str = "<tr>";
                // str += "<form action='' method='post' id='frmeditar'>";

                str += "<input type='hidden' name='idp' id='idp' value='" + reserva.id + "'>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='trabajador' id='reserva_" + reserva.id + "' value='" + reserva.trabajador + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.trabajador + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='plaza' id='plaza_" + reserva.id + "' value='" + reserva.plaza + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.plaza + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='parking' id='parking_" + reserva.id + "' value='" + reserva.parking + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.parking + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='nom_cliente' id='nom_cliente_" + reserva.id + "' value='" + reserva.nom_cliente + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.nom_cliente + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='matricula' id='matricula_" + reserva.id + "' value='" + reserva.matricula + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.matricula + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='marca' id='marca_" + reserva.id + "' value='" + reserva.marca + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.marca + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='modelo' id='modelo_" + reserva.id + "' value='" + reserva.modelo + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.modelo + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='color' id='color_" + reserva.id + "' value='" + reserva.color + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.color + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='num_telf' id='num_telf_" + reserva.id + "' value='" + reserva.num_telf + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.num_telf + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='email' id='email_" + reserva.id + "' value='" + reserva.email + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.email + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='ubicacion_entrada' id='ubicacion_entrada_" + reserva.id + "' value='" + reserva.ubicacion_entrada + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.ubicacion_entrada + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='ubicacion_salida' id='ubicacion_salida_" + reserva.id + "' value='" + reserva.ubicacion_salida + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.ubicacion_salida + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='fecha_entrada' id='fecha_entrada_" + reserva.id + "' value='" + reserva.fecha_entrada + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.fecha_entrada + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='fecha_salida' id='fecha_salida_" + reserva.id + "' value='" + reserva.fecha_salida + "' readonly ondblclick='quitarReadOnly(this,  \"" + reserva.fecha_salida + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input type='button' id='registrar_" + reserva.id + "' class='btn btn-danger' onclick='eliminarreserva(" + reserva.id + ")' value='Eliminar'></td>";

                // str += "</form></tr>";
                tabla += str;
            });
            resultado.innerHTML = tabla;
        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}
