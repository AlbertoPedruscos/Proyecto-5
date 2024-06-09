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

function checkChanges(reservaId, currentValue, newValue) {
    var boton = document.getElementById('registrar_' + reservaId);
    if (currentValue != newValue) {
        boton.setAttribute('onclick', 'confirmarEdicion(' + reservaId + ')');
        boton.classList.remove('btn-danger');
        boton.classList.add('btn', 'btn-success');
        boton.value = 'Confirmar';
    } else {
        boton.setAttribute('onclick', 'eliminarUsuario(' + reservaId + ')');
        boton.classList.remove('btn-success');
        boton.classList.add('btn', 'btn-danger');
        boton.value = 'Eliminar';
    }
}

function formatDateTimeFromInput(datetime) {
    return datetime.replace('T', ' ') + ':00';
}

function checkDate(reservaId, currentValue, newValue) {
    var formattedNewValue = formatDateTimeFromInput(newValue);
    var boton = document.getElementById('registrar_' + reservaId);
    if (currentValue != formattedNewValue) {
        boton.setAttribute('onclick', 'confirmarEdicion(' + reservaId + ')');
        boton.classList.remove('btn-danger');
        boton.classList.add('btn', 'btn-success');
        boton.value = 'Confirmar';
    } else {
        boton.setAttribute('onclick', 'eliminarUsuario(' + reservaId + ')');
        boton.classList.remove('btn-success');
        boton.classList.add('btn', 'btn-danger');
        boton.value = 'Eliminar';
    }
}

// 
function CambiosParkinPlaza(reservaId, currentValue, newValue, dataobject, idobject, plaza) {
    checkChanges(reservaId, currentValue, newValue);

    CambioPlazas(idobject, dataobject, plaza);
}
var marcas = [];

function marca() {
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Parsear la respuesta JSON y almacenarla en un array
                    var data = JSON.parse(this.responseText);
                    // Iterar sobre los datos y almacenar solo las marcas en el array 'marcas'
                    marcas = data.map(function (coche) { // Changed 'let marcas' to 'marcas'
                        return coche.marca;
                    });
                    // Resolver la promesa con el array de marcas
                    resolve(marcas);
                } else {
                    // Rechazar la promesa en caso de error
                    reject(new Error('Error en la solicitud: ' + this.status));
                }
            }
        };

        xhr.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/coches", true);
        xhr.send();
    });
}
// ----------------------
// ESCUCHAR EVENTO ACTUALIZAR FORMULARIO DEL FILTRO
// ----------------------
marca()

filtroNombre.addEventListener("keyup", () => {
    const matrica = filtroNombre.value;
    var fechaini = document.getElementById('fechaini').value;
    var fechafin = document.getElementById('fechafin').value;
    if (matrica == "") {
        if (fechafin == "") {
            ListarEmpresas('', fechaini, '');
        } else {
            ListarEmpresas('', fechaini, fechafin);
        }
    } else {
        if (fechafin == "") {
            ListarEmpresas(matrica, fechaini, '');
        } else {
            ListarEmpresas(matrica, fechaini, fechafin);
        }
    }
});

fechaini.addEventListener("change", () => {
    const fechainivalor = fechaini.value;
    var matrica = document.getElementById('filtroNombre').value;
    var fechafin = document.getElementById('fechafin').value;
    if (matrica == "") {
        if (fechafin == "") {
            ListarEmpresas('', fechainivalor, '');
        } else {
            ListarEmpresas('', fechainivalor, fechafin);
        }
    } else {
        if (fechafin == "") {
            ListarEmpresas(matrica, fechainivalor, '');
        } else {
            ListarEmpresas(matrica, fechainivalor, fechafin);
        }
    }
});

fechafin.addEventListener("change", () => {
    const fechafinvalor = fechafin.value;
    var matrica = document.getElementById('filtroNombre').value;
    var fechaini = document.getElementById('fechaini').value;
    if (matrica == "") {
        if (fechaini == "") {
            ListarEmpresas('', '', fechafinvalor);
        } else {
            ListarEmpresas('', fechaini, fechafinvalor);
        }
    } else {
        if (fechaini == "") {
            ListarEmpresas(matrica, '', fechafinvalor);
        } else {
            ListarEmpresas(matrica, fechaini, fechafinvalor);
        }
    }
});

ListarEmpresas("", "", "");

function ListarEmpresas(matrica, fachaini, fachafin) {
    var resultado = document.getElementById('resultado');

    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('matrica', matrica);
    formdata.append('fachaini', fachaini);
    formdata.append('fachafin', fachafin);

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

            let tabla = '';

            reservas.forEach(function (reserva) {
                let str = "<tr>";

                var ubicacion_salida = reserva.ubicacion_salida ? reserva.ubicacion_salida : '0';
                var ubicacion_entrada = reserva.ubicacion_entrada ? reserva.ubicacion_entrada : '0';
                var firma_entrada = reserva.firma_entrada ? reserva.firma_entrada : 'No firmado';
                var firma_salida = reserva.firma_salida ? reserva.firma_salida : 'No firmado';

                var asd = 0;

                str += "<input type='hidden' name='idp' id='idp' value='" + reserva.id + "'>";
                str += "<td style='margin: 0; text-align:center;'><input type='text' style='border:none; text-align:center; background-color: transparent' name='nombre' id='nombre_" + reserva.id + "' value='" + reserva.nom_cliente + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.nom_cliente + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";

                // Select trabajador 

                str += '<td><select style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 30px;" id="SelectTrabajador_' + reserva.id + '" onchange="checkChanges(' + reserva.id + ', ' + reserva.id_trabajador + ', this.value)">';
                str += "<option value='0'>Sin asignar</option>";
                usuarios.forEach(function (usuario) {
                    str += "<option value='" + usuario.id + "'";
                    if (reserva.id_trabajador == usuario.id) {
                        str += " selected";
                    }
                    str += ">" + usuario.nombre + "</option>";
                });
                str += "</select></td>";

                // parking

                str += '<td><select style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 30px;"id="IDParking_' + reserva.id + '" class="funciona" onchange="CambiosParkinPlaza(' + reserva.id + ', ' + reserva.parking_id + ', this.value,JSON.parse(this.getAttribute(\'data-object\')),this,' + reserva.id_plaza + ')" > ';
                str += "<option value='0'>Sin asignar</option>";

                parkings.forEach(function (parking) {
                    str += "<option value='" + parking.id + "'";
                    if (reserva.parking == parking.nombre) {
                        asd = parking.id;
                        str += " selected";
                    }
                    str += ">" + parking.nombre + "</option>";
                });
                str += "</select></td>";

                // PLAZA

                str += '<td><select style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 30px;"id="mostrarplaza_' + reserva.id + '" onchange="checkChanges(' + reserva.id + ', ' + reserva.id_plaza + ', this.value)" >';
                str += "<option value='0'>ninguno</option>";
                for (let [key, value] of Object.entries(plazas)) {
                    value.forEach(function (plaza) {
                        if (asd == plaza.id_parking) {
                            str += "<option value='" + plaza.id + "'";
                            if (reserva.id_plaza == plaza.id) {
                                str += " selected";
                            }
                            str += ">" + plaza.nombre + "</option>";
                        }
                    });
                }
                str += "</select></td>";

                str += "<td><input style='border:none; text-align:center; background-color: transparent' type='text' name='matricula' id='matricula_" + reserva.id + "' value='" + reserva.matricula + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.matricula + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";

                // Marca

                str += '<td><select class="cochesSelect" style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 30px;"" id="marca_' + reserva.id + '"  onchange="checkChanges(' + reserva.id + ', \'' + reserva.marca + '\', this.value)">';

                marcas.forEach(function (marca) {
                    str += '<option value="' + marca + '"';
                    if (reserva.marca === marca) {
                        str += ' selected';
                    }
                    str += '>' + marca + '</option>';
                });

                str += '</select></td>';

                str += "<td><input style='border:none; text-align:center; background-color: transparent' type='text' name='modelo' id='modelo_" + reserva.id + "'' name='modelo' value='" + reserva.modelo + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.modelo + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                str += "<td><input style='border:none; text-align:center; background-color: transparent' type='text' name='color' id='color_" + reserva.id + "' value='" + reserva.color + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.color + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";

                // Prefijo

                // str += '<p style="margin: 0;"><strong style="border:none;">prefijo:</strong><br>'
                // str +='<select style="background: #007EA7; border-radius: 8px; margin-boton: 8px;color: #f5f6fa;border: none;font-size: 14px;height: 30px;padding: 5px;" id="prefijo" class="prefijo" >';
                // str += '</select></td>';

                str += "<td><input style='border:none; text-align:center; background-color: transparent' type='text' name='num_telf' id='num_telf_" + reserva.id + "' value='" + reserva.num_telf + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.num_telf + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";
                
                str += "<td><input style='border:none; text-align:center; background-color: transparent' type='text' name='email' id='email_" + reserva.id + "' value='" + reserva.email + "' readonly ondblclick='quitarReadOnly(this, \"" + reserva.email + "\")' onchange='activarEdicion(this, \"" + reserva.id + "\")'></td>";

                // Punto recogida 
                // str += "<td><strong style='border:none;'>Punto recogida: </strong> </td>";
                str += '<td><select style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 30px;"id="puntorecogida_' + reserva.id + '" class="puntorecogida" onchange="checkChanges(' + reserva.id + ', ' + ubicacion_entrada + ', this.value)">';
                str += "<option value='0'>Sin asignar</option>";
                ubicaciones.forEach(function (ubicacion) {
                    str += "<option value='" + ubicacion.id + "'";
                    if (reserva.ubicacion_entrada == ubicacion.id) {
                        str += " selected";
                    }
                    str += ">" + ubicacion.nombre_sitio + "</option>";
                });
                str += "</select></td>";

                // Punto entrega

                // str += "<td><strong style='border:none;'>Punto entrega: </strong> </td>";
                str += '<td><select style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 30px;" id="puntoentrega_' + reserva.id + '" class="puntoentrega" onchange="checkChanges(' + reserva.id + ', ' + ubicacion_salida + ', this.value)">';
                str += "<option value='0'>Sin asignar</option>";
                ubicaciones.forEach(function (ubicacion) {
                    str += "<option value='" + ubicacion.id + "'";
                    if (reserva.ubicacion_salida == ubicacion.id) {
                        str += " selected";
                    }
                    str += ">" + ubicacion.nombre_sitio + "</option>";
                });
                str += "</select></td>";
                str += '<td><input type="datetime-local" name="" id="fechaentrada_' + reserva.id + '" value="' + reserva.fecha_entrada + '" onchange="checkDate(' + reserva.id + ', \'' + reserva.fecha_entrada + '\', this.value)" class="form-control" style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 50px;"></td>';
                // str += "<input type='text' id='fechaentrada_" + reserva.id + "' value='" + reserva.fecha_entrada + "' readonly '>";

                str += '<td style="margin: 0;">' + firma_entrada + '</td>';

                // str += '<p style="margin: 0;"><strong>Fecha entrega: </strong> <input type="text" id="fechasalida_' + reserva.id + '" value="' + reserva.fecha_salida + '"></p>';
                str += '<td><input type="datetime-local" name="" id="fechasalida_' + reserva.id + '" value="' + reserva.fecha_salida + '" onchange="checkDate(' + reserva.id + ', \'' + reserva.fecha_salida + '\', this.value)" class="form-control"  style="border-radius: 8px; margin-boton: 8px;color: #000; border: 1px solid black; font-size: 14px; height: 50px;"></td>';

                str += '<td style="margin: 0; ">' + firma_salida + '</td>';
                str += '<td><input type="button" id="registrar_' + reserva.id + '" class="btn btn-danger" onclick="CancelarReserva(' + reserva.id + ')" value="Cancelar"></td>';
                str += '</tr>';


                tabla += str;
            });

            resultado.innerHTML = tabla;

            prefijo();


            var funciona = document.querySelectorAll('.funciona');
            funciona.forEach(element => {
                element.setAttribute('data-object', JSON.stringify(plazas));
            });
        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}

function prefijo() {
    // Crear una nueva solicitud XMLHttpRequest
    var xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Parsear la respuesta JSON
            var data = JSON.parse(this.responseText);
            // Iterar sobre los datos y agregar opciones al select
            var prefijos = data.map(prefijo => {
                return `<option value="${prefijo.prefijo}">${prefijo.pais} (${prefijo.prefijo})</option>`;
            }).join("");
            var prefijoElements = document.querySelectorAll('.prefijo');
            prefijoElements.forEach(element => {
                element.innerHTML = prefijos;
            });
        }
    };
    xhr2.open("GET", "https://644158e3fadc69b8e081cd34.mockapi.io/api/mycontrolpark/prefijo", true);
    xhr2.send();
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

    let mostrarplaza = id.parentElement.nextElementSibling.querySelector('select');
    console.log(mostrarplaza)
    if (!plazas) {
        plazas = id.getAttribute('data-object');
    }
    id = id.value;
    let str = "";
    let plazas2 = plazas[id];
    str += "<option value='0'>ninguno</option>";
    plazas2.forEach(function (plaza) {
        str += "<option value='" + plaza.id + "'";
        if (idplaza == plaza.id) {
            str += " selected";
        }
        str += ">" + plaza.nombre + "</option>";
    });
    mostrarplaza.innerHTML = str;
}

// Cancelar reserva

function CancelarReserva(id) {
    var Trabajador = document.getElementById('nombre_' + id).value;
    Swal.fire({
        title: '¿Cancelar la reserva de <br>  ' + Trabajador + '?',
        icon: 'warning',
        position: 'top-end',
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
                            position: 'top-end',
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            position: 'top-end',
                            title: '¡No se pedo realizar la accion!',
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

// Editar reserva

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
        position: 'top-end',
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
                            position: 'top-end',
                            title: `Reserva de ${nombreValue} modificada correctamente`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                } else {
                    ListarEmpresas('', '', '');
                    Swal.fire({
                        icon: 'error',
                        position: 'top-end',
                        title: 'No se pudo cambiar a ' + nombreValue
                    });
                }
            }
            ajax.send(formdata);
        }
    })
}

// Exportar

// Variable para almacenar los datos de la petición AJAX
var dataFromAjax = null;

// Función para realizar la petición AJAX y guardar los datos
function fetchData() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/listarreservascsv', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.responseType = 'json';

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Guardar los datos en la variable
            dataFromAjax = xhr.response;
            // Filtrar y mostrar los datos (si es necesario)
            exportFilteredDataToCSV();
        }
    };

    xhr.send();
}

// Función para exportar los datos filtrados a CSV
function exportFilteredDataToCSV() {
    if (!dataFromAjax) {
        return;
    }
    // Filtrar los datos antes de exportarlos
    var filtroNombre = document.getElementById('filtroNombre').value.toLowerCase();
    var datosFiltrados = dataFromAjax.filter(function (item) {
        return item.matricula && item.matricula.toLowerCase().includes(filtroNombre);
    });

    // Convertir los datos filtrados a CSV
    var csvData = convertToCSV(datosFiltrados);

    // Crear un archivo CSV y descargarlo
    var blob = new Blob([csvData], { type: 'text/csv;charset=utf-8' });
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
    var csv = '';
    if (data.length > 0) {
        // Obtener las claves de la primera fila para los encabezados del CSV
        var headers = Object.keys(data[0]).join(';');
        csv += headers + '\n';
    }
    // Iterar sobre los datos y construir el string CSV
    data.forEach(function (row) {
        // Crear un arreglo para contener los valores de cada fila
        var rowDataArray = [];
        // Iterar sobre cada propiedad del objeto
        Object.keys(row).forEach(function (key) {
            // Reemplazar los valores específicos si es necesario
            var value = row[key];
            if (value === null) {
                value = ''; // Si el valor es null, establecerlo como una cadena vacía
            } else if (typeof value === 'string') {
                value = value.replace('Antiguo Valor', 'Nuevo Valor'); // Reemplazar si es una cadena
            }
            // Agregar el valor al arreglo
            rowDataArray.push(value);
        });
        // Convertir el arreglo en una fila CSV y agregarlo al string CSV
        var rowData = rowDataArray.join(';') + '\n';
        csv += rowData;
    });
    return csv;
} 