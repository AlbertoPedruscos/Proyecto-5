
// Quitar readonly del formulario

function quitarReadOnly(input, textooriginal) {
    input.removeAttribute('readonly'); // Eliminamos el evento readonly
    input.removeAttribute('ondblclick');
    input.setAttribute('texto-original', textooriginal); // Guardamos el valor original
}

// Activar edicion, cambio atributos del boton

function activarEdicion(input, id) {
    var textooriginal = input.getAttribute('texto-original');
    var boton = document.getElementById('registrar_' + id);
    // console.log(textooriginal)
    if (input.value !== textooriginal) {
        boton.setAttribute('onclick', 'confirmarEdicion(' + id + ')');
        boton.classList.remove('btn-danger');
        boton.classList.add('btn', 'btn-success');
        boton.value = 'Confirmar';
        input.style.border = "1px solid black";
        input.style.backgroundColor = "white";
    } else {
        boton.setAttribute('onclick', 'eliminarUsuario(' + id + ')');
        boton.classList.remove('btn-success');
        boton.classList.add('btn', 'btn-danger');
        boton.value = 'Eliminar';
        input.style.border = "none";
        input.style.backgroundColor = "transparent";
    }
}



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
            var reservas = json.reservas;
            var usuarios = json.usuarios;

            console.log(json.usuarios)
            // Almacenar la info
            let DatosAnteriores = '';
            let DatosActuales = '';
            let DatosPosteriores = '';

            var fechaActualIni = new Date();
            fechaActualIni.setHours(0);
            fechaActualIni.setMinutes(0);
            fechaActualIni.setSeconds(0);

            var fechaActualFin = new Date();
            fechaActualFin.setHours(23);
            fechaActualFin.setMinutes(60);
            fechaActualFin.setSeconds(0);


            var fechaActual = new Date();

            // console.log(fechaActualFin);

            reservas.forEach(function (reserva) {
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
                // console.log("El fechaActual es: " + fechaActualFin);
                if (fechaEntrada > fechaActualIni && fechaSalida < fechaActual) {
                    strexpirados += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    // strexpirados += "<td><select name='rol' id='rol_" + reserva.id + "' class='rol' onchange='activarEdicion(this, \"" + reserva.id + "\")'>";
                    // usuarios.forEach(function (usuario) {

                    //     strexpirados += "<option value='" + usuario.id + "'";
                    //     strexpirados += ">" + usuario.nombre + "</option>";

                    // });
                    // strexpirados += "</select></td>";

                    strexpirados += "<h5 style='margin: 0; text-align:center;'><input style='border:none; background-color: transparent'  type='text' id='cliente_" + reserva.id + "' name='cliente' value='" + reserva.nom_cliente + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.nom_cliente + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></h5>"; strexpirados += "<p style='margin: 0;'><strong>Trabajador: </strong> <input style='border:none; background-color: transparent'  type='text' id='tabajador_" + reserva.id + "' name='tabajador' value='" + trabajador + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.trabajador + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Plaza: </strong> <input style='border:none; background-color: transparent'  type='text' id='plaza_" + reserva.id + "' name='plaza' value='" + plaza + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.plaza + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Parking: </strong> <input style='border:none; background-color: transparent'  type='text' id='parking_" + reserva.id + "' name='parking' value='" + parking + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.matricula + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Matrícula: </strong> <input style='border:none; background-color: transparent'  type='text' id='matricula_" + reserva.id + "' name='matricula' value='" + reserva.matricula + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.matricula + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Marca: </strong> <input style='border:none; background-color: transparent'  type='text' id='marca_" + reserva.id + "' name='marca' value='" + reserva.marca + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.marca + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Modelo: </strong> <input style='border:none; background-color: transparent'  type='text' id='modelo_" + reserva.id + "' name='modelo' value='" + reserva.modelo + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.modelo + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Color: </strong> <input style='border:none; background-color: transparent'  type='text' id='color_" + reserva.id + "' name='color' value='" + reserva.color + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.color + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Contacto: </strong> <input style='border:none; background-color: transparent'  type='text' id='num_telf_" + reserva.id + "' name='num_telf' value='" + reserva.num_telf + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.num_telf + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Email: </strong> <input style='border:none; background-color: transparent'  type='text' id='email_" + reserva.id + "' name='email' value='" + reserva.email + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.email + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Punto recogida: </strong> <input style='border:none; background-color: transparent'  type='text' id='ubi_entrada_" + reserva.id + "' name='ubi_entrada' value='" + reserva.ubicacion_entrada + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.ubicacion_entrada + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Punto entrega: </strong> <input style='border:none; background-color: transparent'  type='text' id='ubi_salida_" + reserva.id + "' name='ubi_salida' value='" + reserva.ubicacion_salida + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.ubicacion_salida + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Fecha entrada: </strong> <input style='border:none; background-color: transparent'  type='text' id='fecha_entrada_" + reserva.id + "' name='fecha_entrada' value='" + reserva.fecha_entrada + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.fecha_entrada + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += '<p style="margin: 0;"><strong>Firma entrada: </strong>' + firma_entrada + '</p>';
                    strexpirados += '<p style="margin: 0;"><strong>Fecha entrega: </strong> <input style="border:none; background-color: transparent"  type="text" id="fecha_salida_' + reserva.id + '" name="fecha_salida" value="' + reserva.fecha_salida + '"></p>';
                    strexpirados += '<p style="margin: 0;"><strong>Firma salida: </strong>' + firma_salida + '</p>';
                    strexpirados += '<button><input type="button" id="registrar_' + reserva.id + '" class="btn btn-danger" onclick="CancelarReserva(' + reserva.id + ')" value="Cancelar"></button>';
                    strexpirados += '</div>';
                } else if (fechaEntrada > fechaActualFin && fechaSalida > fechaActual) {
                    strnuevos += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    strnuevos += "<td><select name='rol' id='rol_" + reserva.id + "' class='rol' onchange='activarEdicion(this, \"" + reserva.id + "\")'>";

                    // usuarios.forEach(function (usuario) {
                    //     if (usuario.id = NULL) {
                    //         strnuevos += "<option value='" + usuario.id + "'>" + usuario.nombre + "</option>";
                    //     }
                    // });

                    strnuevos += "</select></td>";


                    strnuevos += '<h5 style="margin: 0; text-align:center;"><input style="border:none; background-color: transparent"  type="text" id="cliente_' + reserva.id + '" name="cliente" value="' + reserva.nom_cliente + '"></h5>';
                    strnuevos += '<p style="margin: 0;"><strong>Trabajador: </strong> <input style="border:none; background-color: transparent"  type="text" id="tabajador_' + reserva.id + '" name="tabajador" value="' + trabajador + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Plaza: </strong> <input style="border:none; background-color: transparent"  type="text" id="plaza_' + reserva.id + '" name="plaza" value="' + plaza + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Parking: </strong> <input style="border:none; background-color: transparent"  type="text" id="parking_' + reserva.id + '" name="parking" value="' + parking + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Matrícula: </strong> <input style="border:none; background-color: transparent"  type="text" id="matricula_' + reserva.id + '" name="matricula" value="' + reserva.matricula + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Marca: </strong> <input style="border:none; background-color: transparent"  type="text" id="marca_' + reserva.id + '" name="marca" value="' + reserva.marca + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Modelo: </strong> <input style="border:none; background-color: transparent"  type="text" id="modelo_' + reserva.id + '" name="modelo" value="' + reserva.modelo + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Color: </strong> <input style="border:none; background-color: transparent"  type="text" id="color_' + reserva.id + '" name="color" value="' + reserva.color + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Contacto: </strong> <input style="border:none; background-color: transparent"  type="text" id="num_telf_' + reserva.id + '" name="num_telf" value="' + reserva.num_telf + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Email: </strong> <input style="border:none; background-color: transparent"  type="text" id="email_' + reserva.id + '" name="email" value="' + reserva.email + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Punto recogida: </strong> <input style="border:none; background-color: transparent"  type="text" id="ubi_entrada_' + reserva.id + '" name="ubi_entrada" value="' + reserva.ubicacion_entrada + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Punto entrega: </strong> <input style="border:none; background-color: transparent"  type="text" id="ubi_salida_' + reserva.id + '" name="ubi_salida" value="' + reserva.ubicacion_salida + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Fecha entrada: </strong> <input style="border:none; background-color: transparent"  type="text" id="fecha_entrada_' + reserva.id + '" name="fecha_entrada" value="' + reserva.fecha_entrada + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Firma entrada: </strong>' + firma_entrada + '</p>';
                    strnuevos += '<p style="margin: 0;"><strong>Fecha entrega: </strong> <input style="border:none; background-color: transparent"  type="text" id="fecha_salida_' + reserva.id + '" name="fecha_salida" value="' + reserva.fecha_salida + '"></p>';
                    strnuevos += '<p style="margin: 0;"><strong>Firma salida: </strong>' + firma_salida + '</p>';
                    strnuevos += '<button><input type="button" id="registrar_' + reserva.id + '" class="btn btn-danger" onclick="CancelarReserva(' + reserva.id + ')" value="Cancelar"></button>';
                    strnuevos += '</div>';
                } else {

                    stractivos += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    stractivos += "<td><select name='rol' id='rol_" + reserva.id + "' class='rol' onchange='activarEdicion(this, \"" + reserva.id + "\")'>";
                    // usuarios.forEach(function (usuario) {

                    //     stractivos += "<option value='" + usuario.id + "'";
                    //     stractivos += ">" + usuario.nombre + "</option>";

                    // });
                    stractivos += "</select></td>";


                    stractivos += '<h5 style="margin: 0; text-align:center;"><input style="border:none; background-color: transparent"  type="text" id="cliente_' + reserva.id + '" name="cliente" value="' + reserva.nom_cliente + '' + reserva.id + '"></h5>';
                    stractivos += '<p style="margin: 0;"><strong>Trabajador: </strong> <input style="border:none; background-color: transparent"  type="text" id="tabajador_' + reserva.id + '" name="tabajador" value="' + trabajador + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Plaza: </strong> <input style="border:none; background-color: transparent"  type="text" id="plaza_' + reserva.id + '" name="plaza" value="' + plaza + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Parking: </strong> <input style="border:none; background-color: transparent"  type="text" id="parking_' + reserva.id + '" name="parking" value="' + parking + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Matrícula: </strong> <input style="border:none; background-color: transparent"  type="text" id="matricula_' + reserva.id + '" name="matricula" value="' + reserva.matricula + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Marca: </strong> <input style="border:none; background-color: transparent"  type="text" id="marca_' + reserva.id + '" name="marca" value="' + reserva.marca + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Modelo: </strong> <input style="border:none; background-color: transparent"  type="text" id="modelo_' + reserva.id + '" name="modelo" value="' + reserva.modelo + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Color: </strong> <input style="border:none; background-color: transparent"  type="text" id="color_' + reserva.id + '" name="color" value="' + reserva.color + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Contacto: </strong> <input style="border:none; background-color: transparent"  type="text" id="num_telf_' + reserva.id + '" name="num_telf" value="' + reserva.num_telf + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Email: </strong> <input style="border:none; background-color: transparent"  type="text" id="email_' + reserva.id + '" name="email" value="' + reserva.email + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Punto recogida: </strong> <input style="border:none; background-color: transparent"  type="text" id="ubi_entrada_' + reserva.id + '" name="ubi_entrada" value="' + reserva.ubicacion_entrada + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Punto entrega: </strong> <input style="border:none; background-color: transparent"  type="text" id="ubi_salida_' + reserva.id + '" name="ubi_salida" value="' + reserva.ubicacion_salida + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Fecha entrada: </strong> <input style="border:none; background-color: transparent"  type="text" id="fecha_entrada_' + reserva.id + '" name="fecha_entrada" value="' + reserva.fecha_entrada + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Firma entrada: </strong>' + firma_entrada + '</p>';
                    stractivos += '<p style="margin: 0;"><strong>Fecha entrega: </strong> <input style="border:none; background-color: transparent"  type="text" id="fecha_salida_' + reserva.id + '" name="fecha_salida" value="' + reserva.fecha_salida + '"></p>';
                    stractivos += '<p style="margin: 0;"><strong>Firma salida: </strong>' + firma_salida + '</p>';
                    stractivos += '<button><input type="button" id="registrar_' + reserva.id + '" class="btn btn-danger" onclick="CancelarReserva(' + reserva.id + ')" value="Cancelar"></button>';
                    stractivos += '</div>';
                }
                DatosAnteriores += strexpirados;
                DatosActuales += stractivos;
                DatosPosteriores += strnuevos;
            });

            expirados.innerHTML = DatosAnteriores;
            activos.innerHTML = DatosActuales;
            nuevos.innerHTML = DatosPosteriores;

        } else {
            expirados.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}

function CancelarReserva(id) {
    var Trabajador = document.getElementById('cliente_' + id).value;
    console.log(id)
    Swal.fire({
        title: '¿Cancelar la reserva de <br>  ' + Trabajador + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('id', id);
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/CancelarReserva');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText == "ok") {
                        ListarEmpresas('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            }
            ajax.send(formdata);
        }
    })
}