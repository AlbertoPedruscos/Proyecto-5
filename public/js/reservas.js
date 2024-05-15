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
            var parkings = json.parkings;
            var plazas = json.plazas;
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

            // console.log(plazas);

            reservas.forEach(function (reserva) {
                var strexpirados = "";
                var stractivos = "";
                var strnuevos = "";

                var trabajador = reserva.trabajador ? reserva.trabajador : 'Selecciona un trabajador';
                var parkingact = reserva.parking ? reserva.parking : 'Selecciona un parking';
                var plaza = reserva.plaza ? reserva.plaza : 'Selecciona una plaza';
                var firma_entrada = reserva.firma_entrada ? reserva.firma_entrada : 'No firmado';
                var firma_salida = reserva.firma_salida ? reserva.firma_salida : 'No firmado';

                let fechaEntrada = new Date(reserva.fecha_entrada);
                let fechaSalida = new Date(reserva.fecha_salida);

                // console.log(reservas)

                // console.log("El contador es: " + fechaSalida);
                // console.log("El fechaActual es: " + fechaActualFin);

                if (fechaEntrada < fechaActualIni && fechaSalida < fechaActual) {
                    strexpirados += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    strexpirados += '<h5>' + reserva.nom_cliente + '</h5>';

                    strexpirados += '<p>Trabajador:';
                    strexpirados += '<select name="" id="">';
                    if (trabajador === "Selecciona un trabajador") {
                        strexpirados += '<option value="" selected>Selecciona un trabajador</option>';
                    } else {
                        strexpirados += '<option value="">Selecciona un trabajador</option>';
                    }
                    usuarios.forEach(function (usuario) {
                        const selected = trabajador === usuario.nombre ? "selected" : "";
                        strexpirados += '<option value="' + usuario.id + '" ' + selected + '>' + usuario.nombre + '</option>';
                    });
                    strexpirados += '</select></p>';

                    // Parkings

                    strexpirados += '<p><select name="parking" id="parking">';
                    if (parkingact === "Selecciona un parking") {
                        strexpirados += '<option value="" selected>Selecciona un parking</option>';
                    } else {
                        strexpirados += "<option value=''>Selecciona un parking</option>";
                    }

                    parkings.forEach(function (parking) {
                        const selected = reserva.parkingID === parking.id ? "selected" : "";
                        strexpirados += '<option value="' + parking.id + '" ' + selected + '>' + parking.nombre + '</option>';
                    });
                    strexpirados += '</select></p>';

                    // Plazas 

                    strexpirados += '<p><select name="plaza" id="plaza" >';

                    if (plaza === "Selecciona un plaza") {
                        strexpirados += '<option value="" selected>Selecciona una plza</option>';
                    } else {
                        strexpirados += "<option value=''>Selecciona una plaza</option>";
                    }

                    plazas.forEach(function (plaza) {
                        const selected = reserva.id_plaza === plaza.id ? "selected" : "";
                        strexpirados += '<option value="' + plaza.id + '" ' + selected + '>' + plaza.nombre + '</option>';
                    });
                    strexpirados += '</select></p>';

                    strexpirados += '<p>Matrícula: ' + reserva.matricula + '</p>';
                    strexpirados += '<p>Marca: ' + reserva.marca + '</p>';
                    strexpirados += '<p>Modelo: ' + reserva.modelo + '</p>';
                    strexpirados += '<p>Color: ' + reserva.color + '</p>';
                    strexpirados += '<p>Contacto: ' + reserva.num_telf + '</p>';
                    strexpirados += '<p>Email: ' + reserva.email + '</p>';
                    strexpirados += `<p>
                        <select name="ubicacion_" id="ubicacion_entrada">
                            <option value="">Elige un punto de recogida</option>
                            <option value="Aeropuerto T1">Aeropuerto T1</option>
                            <option value="Aeropuerto T2">Aeropuerto T2</option>
                            <option value="Puerto">Puerto</option>
                        </select></p>`;
                    strexpirados += `<p>
                        <select name="ubicacion_salida" id="ubicacion_salida">
                            <option value="Aeropuerto T1"> Aeropuerto T1</option>
                            <option value="Aeropuerto T2"> Aeropuerto T2</option>
                            <option value="Puerto">Puerto</option>
                        </select></p>`;
                    strexpirados += '<p>Fecha entrada: ' + reserva.fecha_entrada + '</p>';
                    strexpirados += '<p>Firma entrada: ' + firma_entrada + '</p>';
                    strexpirados += '<p>Fecha entrega: ' + reserva.fecha_salida + '</p>';
                    strexpirados += '<p>Firma salida: ' + firma_salida + '</p>';
                    strexpirados += '</div>';
                    // } else if (fechaEntrada > fechaActualFin && fechaSalida > fechaActual) {
                    //     strnuevos += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    //     strnuevos += "<h5>" + reserva.nom_cliente + "</h5>";
                    //     strnuevos += "<p>Trabajador:";
                    //     strnuevos += "<select name='rol' id='rol_" + reserva.id + "' class='rol'>";
                    //     if (trabajador === "No asignado") {
                    //         strnuevos += "<option value='' selected>No asignado</option>";
                    //     } else {
                    //         strnuevos += "<option value=''>No asignado</option>";
                    //     }
                    //     usuarios.forEach(function (usuario) {
                    //         const selected = trabajador === usuario.nombre ? "selected" : "";
                    //         strnuevos += `< option value = '${usuario.id}' ${selected}> ${usuario.nombre}</ > `;
                    //     });
                    //     strnuevos += "</select></p>";
                    //     strnuevos += "<p>Parking: ";
                    //     strnuevos += "<select name='rol' id='rol_" + reserva.id + "'>";
                    //     if (trabajador === "No asignado") {
                    //         strnuevos += "<option value='' selected>No asignado</option>";
                    //     } else {
                    //         strnuevos += "<option value=''>No asignado</option>";
                    //     }
                    //     usuarios.forEach(function (usuario) {
                    //         const selected = trabajador === usuario.nombre ? "selected" : "";
                    //         strnuevos += `< option value = '${usuario.id}' ${selected}> ${usuario.nombre}</ > `;
                    //     });
                    //     strnuevos += "</select></p>";
                    //     strnuevos += "<p>Plaza: " + plaza + "</p>";
                    //     strnuevos += "<p>Matrícula: " + reserva.matricula + "</p>";
                    //     strnuevos += "<p>Marca: " + reserva.marca + "</p>";
                    //     strnuevos += "<p>Modelo: " + reserva.modelo + "</p>";
                    //     strnuevos += "<p>Color: " + reserva.color + "</p>";
                    //     strnuevos += "<p>Contacto: " + reserva.num_telf + "</p>";
                    //     strnuevos += "<p>Email: " + reserva.email + "</p>";
                    //     strnuevos += `< p > Punto recogida:
                    //         <select name="ubicacion_" id="ubicacion_entrada">
                    //             <option value="Aeropuerto T1">Aeropuerto T1</option>
                    //             <option value="Aeropuerto T2">Aeropuerto T2</option>
                    //             <option value="Puerto">Puerto</option>
                    //         </select>
                    //                     </ > `;
                    //     strnuevos += `< p > Punto entrega:
                    //         <select name="ubicacion_salida" id="ubicacion_salida">
                    //             <option value="Aeropuerto T1"> Aeropuerto T1</option>
                    //             <option value="Aeropuerto T2"> Aeropuerto T2</option>
                    //             <option value="Puerto">Puerto</option>
                    //         </select>
                    //                     </ > `;
                    //     strnuevos += '<p>Fecha entrada: ' + reserva.fecha_entrada + '</p>';
                    //     strnuevos += '<p>Firma entrada: ' + firma_entrada + '</p>';
                    //     strnuevos += '<p>Fecha entrega: ' + reserva.fecha_salida + '</p>';
                    //     strnuevos += '<p>Firma salida: ' + firma_salida + '</p>';
                    //     strnuevos += '</div>';
                } else {
                    //     stractivos += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    //     stractivos += "<h5>" + reserva.nom_cliente + "</h5>";
                    //     stractivos += "<p>Trabajador:";
                    //     stractivos += "<select name='rol' id='rol_" + reserva.id + "' class='rol'>";
                    //     if (trabajador === "No asignado") {
                    //         stractivos += "<option value='' selected>No asignado</option>";
                    //     } else {
                    //         stractivos += "<option value=''>No asignado</option>";
                    //     }
                    //     usuarios.forEach(function (usuario) {
                    //         const selected = trabajador === usuario.nombre ? "selected" : "";
                    //         stractivos += `< option value = '${usuario.id}' ${selected}> ${usuario.nombre}</ > `;
                    //     });
                    //     stractivos += "</select></p>";
                    //     stractivos += "<p>Parking: ";
                    //     stractivos += "<select name='rol' id='rol_" + reserva.id + "'>";
                    //     if (trabajador === "No asignado") {
                    //         stractivos += "<option value='' selected>No asignado</option>";
                    //     } else {
                    //         stractivos += "<option value=''>No asignado</option>";
                    //     }
                    //     usuarios.forEach(function (usuario) {
                    //         const selected = trabajador === usuario.nombre ? "selected" : "";
                    //         stractivos += `< option value = '${usuario.id}' ${selected}> ${usuario.nombre}</ > `;
                    //     });
                    //     stractivos += "</select></p>";
                    //     stractivos += "<p>Plaza: " + plaza + "</p>";
                    //     stractivos += "<p>Matrícula: " + reserva.matricula + "</p>";
                    //     stractivos += "<p>Marca: " + reserva.marca + "</p>";
                    //     stractivos += "<p>Modelo: " + reserva.modelo + "</p>";
                    //     stractivos += "<p>Color: " + reserva.color + "</p>";
                    //     stractivos += "<p>Contacto: " + reserva.num_telf + "</p>";
                    //     stractivos += "<p>Email: " + reserva.email + "</p>";
                    //     stractivos += `< p > Punto recogida:
                    //         <select name="ubicacion_" id="ubicacion_entrada">
                    //             <option value="Aeropuerto T1">Aeropuerto T1</option>
                    //             <option value="Aeropuerto T2">Aeropuerto T2</option>
                    //             <option value="Puerto">Puerto</option>
                    //         </select>
                    //                     </ > `;
                    //     stractivos += `< p > Punto entrega:
                    //         <select name="ubicacion_salida" id="ubicacion_salida">
                    //             <option value="Aeropuerto T1"> Aeropuerto T1</option>
                    //             <option value="Aeropuerto T2"> Aeropuerto T2</option>
                    //             <option value="Puerto">Puerto</option>
                    //         </select>
                    //                     </ > `;
                    //     stractivos += '<p>Fecha entrada: ' + reserva.fecha_entrada + '</p>';
                    //     stractivos += '<p>Firma entrada: ' + firma_entrada + '</p>';
                    //     stractivos += '<p>Fecha entrega: ' + reserva.fecha_salida + '</p>';
                    //     stractivos += '<p>Firma salida: ' + firma_salida + '</p>';
                    //     stractivos += '</div>';
                }
                DatosAnteriores += strexpirados;
                // DatosActuales += stractivos;
                // DatosPosteriores += strnuevos;
            });

            expirados.innerHTML = DatosAnteriores;
            // activos.innerHTML = DatosActuales;
            // nuevos.innerHTML = DatosPosteriores;

        } else {
            expirados.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}



function CancelarReserva(id) {
    var Trabajador = document.getElementById('cliente_' + id).value;
    // console.log(id)
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