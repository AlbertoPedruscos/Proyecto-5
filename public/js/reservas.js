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
            var parkings = json.parkings;
            var plazas = json.plazas;
            var ubicaciones = json.ubicaciones;

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

            reservas.forEach(function (reserva) {
                let strexpirados = "";
                let stractivos = "";
                let strnuevos = "";

                var firma_entrada = reserva.firma_entrada ? reserva.firma_entrada : 'No firmado';
                var firma_salida = reserva.firma_salida ? reserva.firma_salida : 'No firmado';

                let fechaEntrada = new Date(reserva.fecha_entrada);
                let fechaSalida = new Date(reserva.fecha_salida);
                var asd = 0;
                if (fechaEntrada < fechaActualIni && fechaSalida < fechaActualFin) {
                    strexpirados += '<div style="border: 1px solid #ccc; padding: 3%; margin-bottom: 20px; background-color: #f9f9f9;">';
                    strexpirados += "<input type='hidden' name='idp' id='idp' value='" + reserva.id + "'>";
                    strexpirados += "<h5 style='margin: 0; text-align:center;'><input type='text' name='nombre' id='nombre_" + reserva.id + "' value='" + reserva.nom_cliente + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.nom_cliente + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></h5>";
                    // str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='nombre' id='nombre_" + usuario.id + "' value='" + usuario.nombre + "' readonly ondblclick='quitarReadOnly(this, \"" + usuario.nombre + "\")' onchange='activarEdicion(this, \"" + usuario.id + "\")'></td>";

                    // Select trabajador 

                    strexpirados += "<strong>Trabajador: </strong>";
                    strexpirados += '<select id="SelectTrabajador_' + reserva.id + '">';
                    strexpirados += "<option value='0'>Sin asignar</option>";
                    usuarios.forEach(function (usuario) {
                        strexpirados += "<option value='" + usuario.id + "'";
                        if (reserva.id_trabajador == usuario.id) {
                            strexpirados += " selected";
                        }
                        strexpirados += ">" + usuario.nombre + "</option>";

                    });
                    strexpirados += "</select>";

                    // Parkings

                    strexpirados += "<br><strong>Parking: </strong>";
                    strexpirados += "<select id='IDParking' class='funciona'>";
                    strexpirados += "<option value='0'>Sin asignar</option>";

                    parkings.forEach(function (parking) {
                        strexpirados += "<option value='" + parking.id + "'";
                        if (reserva.parking == parking.nombre) {
                            asd = parking.id;
                            strexpirados += " selected";
                        }
                        strexpirados += ">" + parking.nombre + "</option>";
                    });
                    strexpirados += "</select>";

                    // Plazas

                    strexpirados += "<br><strong>Plazas: </strong>";
                    strexpirados += "<select id='mostrarplaza_" + reserva.id + "' >";
                    strexpirados += "<option value='0'>selecciona una opcion</option>";
                    for (let [key, value] of Object.entries(plazas)) {
                        value.forEach(function (plaza) {
                            if (asd == plaza.id_parking) {
                                strexpirados += "<option value='" + plaza.id + "'";
                                if (reserva.id_plaza == plaza.id) {
                                    strexpirados += " selected";
                                }
                                strexpirados += ">" + plaza.nombre + "</option>";
                            }
                        });
                    }
                    strexpirados += "</select>";

                    strexpirados += "<p style='margin: 0;'><strong>Matrícula: </strong> <input type='text' name='matricula' id='matricula_" + reserva.id + "' value='" + reserva.matricula + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.matricula + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";

                    // Marca

                    // strexpirados += "<p style='margin: 0;'><strong>Marca: </strong> <input type='text' id='marca_" + reserva.id + "' name='marca' value='" + reserva.marca + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.marca + "\")'></p>";
                    strexpirados += '<p style="margin: 0;"><strong>Marca:</strong><select class="cochesSelect" id="marca_' + reserva.id + '">';
                    strexpirados += '</select></p>';


                    strexpirados += "<p style='margin: 0;'><strong>Modelo: </strong> <input type='text' name='modelo' id='modelo_" + reserva.id + "'' name='modelo' value='" + reserva.modelo + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.modelo + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Color: </strong> <input type='text' name='color' id='color_" + reserva.id + "' value='" + reserva.color + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.color + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";

                    // Prefijo

                    strexpirados += '<p style="margin: 0;"><strong>prefijo:</strong><select id="prefijo" class="prefijo" >';
                    strexpirados += '</select></p>';

                    strexpirados += "<p style='margin: 0;'><strong>Contacto: </strong> <input type='text' name='num_telf' id='num_telf_" + reserva.id + "' value='" + reserva.num_telf + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.num_telf + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";
                    strexpirados += "<p style='margin: 0;'><strong>Email: </strong> <input type='text' name='email' id='email_" + reserva.id + "' value='" + reserva.email + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.email + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></p>";

                    // Punto recogida 

                    strexpirados += "<p style='margin: 0;'><strong>Punto recogida: </strong> </p>";
                    strexpirados += "<select id='puntorecogida_" + reserva.id + "' class='puntorecogida' >";
                    strexpirados += "<option value='0'>Sin asignar</option>";
                    ubicaciones.forEach(function (ubicacion) {
                        strexpirados += "<option value='" + ubicacion.id + "'";
                        if (reserva.ubicacion_entrada == ubicacion.id) {
                            strexpirados += " selected";
                        }
                        strexpirados += ">" + ubicacion.nombre_sitio + "</option>";
                    });
                    strexpirados += "</select>";

                    // Punto entrega

                    strexpirados += "<p style='margin: 0;'><strong>Punto entrega: </strong> </p>";
                    strexpirados += "<select id='puntoentrega_" + reserva.id + "' class='puntoentrega' >";
                    strexpirados += "<option value='0'>Sin asignar</option>";
                    ubicaciones.forEach(function (ubicacion) {
                        strexpirados += "<option value='" + ubicacion.id + "'";
                        if (reserva.ubicacion_entrada == ubicacion.id) {
                            strexpirados += " selected";
                        }
                        strexpirados += ">" + ubicacion.nombre_sitio + "</option>";
                    });
                    strexpirados += "</select>";

                    strexpirados += "<p style='margin: 0;'><strong>Fecha entrada: </strong> <input type='text' id='fechaentrada_" + reserva.id + "' value='" + reserva.fecha_entrada + "' readonly '></p>";
                    strexpirados += '<p style="margin: 0;"><strong>Firma entrada: </strong>' + firma_entrada + '</p>';
                    strexpirados += '<p style="margin: 0;"><strong>Fecha entrega: </strong> <input type="text" id="fechasalida_' + reserva.id + '" value="' + reserva.fecha_salida + '"></p>';
                    strexpirados += '<p style="margin: 0;"><strong>Firma salida: </strong>' + firma_salida + '</p>';
                    strexpirados += '<button><input type="button" id="registrar_' + reserva.id + '" class="btn btn-danger" onclick="CancelarReserva(' + reserva.id + ')" value="Cancelar"></button>';
                    strexpirados += '</div>';
                }
                DatosAnteriores += strexpirados;
                DatosActuales += stractivos;
                DatosPosteriores += strnuevos;
            });

            expirados.innerHTML = DatosAnteriores;
            activos.innerHTML = DatosActuales;
            nuevos.innerHTML = DatosPosteriores;

            prefijo();
            marca();

            var funciona = document.querySelectorAll('.funciona');
            funciona.forEach(element => {
                element.setAttribute('data-object', JSON.stringify(plazas));
            });
            // CargaPLaza();
            // var funciona = document.querySelectorAll('.prefijo');
            // funciona.forEach(element => {
            //     element.setAttribute('data-object', JSON.stringify(plazas));
            // });
        } else {
            expirados.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}

function confirmarEdicion(id) {
    var nombreValue = document.getElementById('nombre_' + id).value;
    var selecttrabajador = document.getElementById('SelectTrabajador_' + id).value;
    var mostrarplaza = document.getElementById('mostrarplaza_' + id).value;
    var matriculaValue = document.getElementById('matricula_' + id).value;
    var selectmarca = document.getElementById('marca_' + id).value;
    var modeloValue = document.getElementById('modelo_' + id).value;
    var colorValue = document.getElementById('color_' + id).value;
    var numtelfValue = document.getElementById('num_telf_' + id).value;
    var emailValue = document.getElementById('email_' + id).value;
    var puntorecogida = document.getElementById('puntorecogida_' + id).value;
    var puntosalida = document.getElementById('puntoentrega_' + id).value;
    var fechaentrada = document.getElementById('fechaentrada_' + id).value;
    var fechasalida = document.getElementById('fechasalida_' + id).value;


    Swal.fire({
        title: 'Esta seguro de editar a ' + nombreValue + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('idp', id);
            formdata.append('nombre', nombreValue);
            formdata.append('trabajador', selecttrabajador);
            formdata.append('plaza', mostrarplaza);
            formdata.append('matricula', matriculaValue);
            formdata.append('marca', selectmarca);
            formdata.append('modelo', modeloValue);
            formdata.append('color', colorValue);
            formdata.append('telf', numtelfValue);
            formdata.append('email', emailValue);
            formdata.append('puntorecogida', puntorecogida);
            formdata.append('puntosalida', puntosalida);
            formdata.append('fechaentrada', fechaentrada);
            formdata.append('fechasalida', fechasalida);
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/ReservasEditar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText === "ok") {
                        ListarEmpresas('', '', '');
                        Swal.fire({
                            icon: 'success',
                            title: nombreValue,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                } else {
                    ListarEmpresas('', '', '');
                    Swal.fire({
                        icon: 'error',
                        title: 'No se puedo cambiar a ' + nombreValue
                    });
                }
            }
            ajax.send(formdata);
        }
    })
}










function CargaPLaza() {
    var IDParking = document.querySelector("#IDParking");
    // IDParking.value = 0;
    if (IDParking.value == "0") {
        IDParking.value = IDParking.options[1].value;
    }
    const event = new Event('change', { bubbles: true });
    // Disparar el evento 'change'
    IDParking.dispatchEvent(event);
};

function CambioPlazas(id, plazas, idplaza) {
    let mostrarplaza = id.nextSibling.nextElementSibling.nextElementSibling;
    if (!plazas) {
        plazas = id.getAttribute('data-object');
    }
    id = id.value;
    let strexpirados = "";
    let plazas2 = plazas[id];
    strexpirados += "<option value='0'>Seleccionar una plaza</option>";
    plazas2.forEach(function (plaza) {
        strexpirados += "<option value='" + plaza.id + "'";
        if (idplaza == plaza.id) {
            strexpirados += " selected";
        }
        strexpirados += ">" + plaza.nombre + "</option>";
    });
    mostrarplaza.innerHTML = strexpirados;
}






















function marca() {
    // Tipo Coche
    var cochesSelects = document.querySelectorAll('.cochesSelect');
    // Crear una nueva solicitud XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Parsear la respuesta JSON
            var data = JSON.parse(this.responseText);
            // Iterar sobre los datos y agregar opciones al select
            data.forEach(coche => {
                cochesSelects.forEach(cochesSelect => {
                    console.log(coche.id_reserva);
                    var option = document.createElement("option");
                    option.value = coche.marca;
                    option.textContent = coche.marca;
                    cochesSelect.appendChild(option);

                    // Aquí comparas si el valor coincide y lo marcas como seleccionado
                    if (cochesSelect.dataset.idreserva === coche.id_reserva) {
                        option.selected = true;
                    }
                   
                });
            });
        }
    };

    // Abrir y enviar la solicitud
    xhr.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/coches", true);
    xhr.send();
}

function prefijo() {
    // Prefijo
    var prefijo = document.getElementById("prefijo");
    // Crear una nueva solicitud XMLHttpRequest
    var xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function () {
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
    xhr2.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/prefijo", true);
    xhr2.send();
}

function CancelarReserva(id) {
    var Trabajador = document.getElementById('cliente_' + id).value;
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






// Variable para almacenar los datos de la petición AJAX
var dataFromAjax = null;

// Función para realizar la petición AJAX y guardar los datos
function fetchData() {
    console.log('Fetching data...');
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/listarreservascsv', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.responseType = 'json';

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('Data fetched successfully:', xhr.response);
            // Guardar los datos en la variable
            dataFromAjax = xhr.response;
            // Filtrar y mostrar los datos (si es necesario)
            filterAndDisplayData();
        } else {
            console.error('Error en la petición AJAX:', xhr.status, xhr.statusText);
        }
    };

    xhr.onerror = function () {
        console.error('Request failed');
    };

    xhr.send();
}

// Función para filtrar y mostrar los datos
function filterAndDisplayData() {
    if (!dataFromAjax) {
        console.error('No hay datos disponibles para filtrar.');
        return;
    }

    // Aquí puedes filtrar los datos según los criterios seleccionados por el usuario
    var filtroNombre = document.getElementById('filtroNombre').value.toLowerCase();
    // console.log("filtrando", filtroNombre)
    var datosFiltrados = dataFromAjax.filter(function (item) {
        // console.log(item.nom_cliente && item.nom_cliente.toLowerCase().includes(filtroNombre))
        return item.nom_cliente && item.nom_cliente.toLowerCase().includes(filtroNombre);
    });

    // Mostrar los datos filtrados en la tabla o en cualquier otro lugar de tu página
    var tabla = document.getElementById('tablaDatos').getElementsByTagName('tbody')[0];
    tabla.innerHTML = ''; // Limpiar la tabla antes de mostrar los nuevos datos

    datosFiltrados.forEach(function (item) {
        var row = tabla.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        // Añade más celdas según tus datos
        cell1.textContent = item.nom_cliente;
        cell2.textContent = item.matricula;
        // Añade más contenido según tus datos
    });
}

// Función para exportar los datos filtrados a CSV
function exportFilteredDataToCSV() {
    if (!dataFromAjax) {
        console.error('No hay datos disponibles para exportar.');
        return;
    }
    // Filtrar los datos antes de exportarlos
    var filtroNombre = document.getElementById('filtroNombre').value.toLowerCase();
    var datosFiltrados = dataFromAjax.filter(function (item) {
        return item.nom_cliente && item.nom_cliente.toLowerCase().includes(filtroNombre);
    });

    // Convertir los datos filtrados a CSV
    var csvData = convertToCSV(datosFiltrados);

    // Crear un archivo CSV y descargarlo
    var blob = new Blob([csvData], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'datos_filtrados.csv';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
}

// Función para convertir los datos a formato CSV
function convertToCSV(data) {
    var csv = 'Nombre,Matricula\n';
    // if (data.length > 0) {
    //     var headers = Object.keys(data[0]).join(',');
    //     csv += headers + '\n';
    // }
    // Iterar sobre los datos y construir el string CSV
    data.forEach(function (row) {
        csv += row.nom_cliente + ',' + row.matricula + '\n';
    });

    return csv;
}
