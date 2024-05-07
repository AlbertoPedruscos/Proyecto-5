
// Mostrar formulatio oculto

document.addEventListener("DOMContentLoaded", function () {
    var nav = document.getElementById('menu');
    var submenu = document.getElementById('submenu');

    nav.addEventListener('click', function () {
        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
    });
});

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

const estadosCheckbox = {};

function guardarEstadosCheckbox() {
    const checkboxes = document.querySelectorAll('.checkbox-usuaiors');
    checkboxes.forEach(function (checkbox) {
        estadosCheckbox[checkbox.value] = checkbox.checked;
    });
    // console.log(estadosCheckbox);
}

// ----------------------
// ESCUCHAR EVENTO ACTUALIZAR FORMULARIO DEL FILTRO
// ----------------------
const inputNombre = document.getElementById('nombre');
inputNombre.addEventListener("keyup", actualizarFiltro);

let filtroRol = '';

function actualizarFiltro() {
    const nombre = inputNombre.value;
    ListarEmpresas(nombre, filtroRol, '2');
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('filtroRol').addEventListener('change', function (event) {
        const valorSeleccionado = event.target.value;
        filtroRol = valorSeleccionado;
        actualizarFiltro();
    });
});

ListarEmpresas('', '', 1);

function ListarEmpresas(nombre, filtroRol, filtro = 1) {
    var resultado = document.getElementById('resultado');
    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('nombre', nombre);
    formdata.append('rol', filtroRol);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/listarreservas');

    ajax.onload = function () {
        let tabla = '';
        if (ajax.status == 200) {
            var json = JSON.parse(ajax.responseText);
            var usuarios = json.usuarios;
            var roles = json.roles;

            // roles

            if (filtro === 1) {
                var filtroRol = document.getElementById('filtroRol');
                var tabla2 = '';
                tabla2 += '<option value="">Todo</option>';
                roles.forEach(function (rol) {
                    if (rol.id !== 1) {
                        tabla2 += '<option value="' + rol.id + '"> ' + rol.nombre + '</option>';
                    }
                });
                filtroRol.innerHTML = tabla2;
            }

            // tabla usuarios

            usuarios.forEach(function (usuario) {
                let str = "<tr>";
                str += "<form action='' method='post' id='frmeditar'>";
                if (usuario.id_rol == 1) {
                    str += "<td>" + usuario.nombre + " </td>";
                    str += "<td>" + usuario.apellidos + "</td>";
                    str += "<td>" + usuario.email + "</td>";
                    str += "<td>" + usuario.nom_rol + "</td>";
                    str += '<td></td>';
                    str += '<td></td>';    
                } else {
                    str += "<input type='hidden' name='idp' id='idp' value='" + usuario.id + "'>";
                    str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='nombre' id='nombre_" + usuario.id + "' value='" + usuario.nombre + "' readonly ondblclick='quitarReadOnly(this, \"" + usuario.nombre + "\")' onchange='activarEdicion(this, \"" + usuario.id + "\")'></td>";
                    str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='apellidos' id='apellidos_" + usuario.id + "' value='" + usuario.apellidos + "' readonly ondblclick='quitarReadOnly(this, \"" + usuario.apellidos + "\")' onchange='activarEdicion(this, \"" + usuario.id + "\")'></td>";
                    str += "<td><input type='text' style='border:none; text-align:center; background-color: transparent' name='email' id='email_" + usuario.id + "' value='" + usuario.email + "' readonly ondblclick='quitarReadOnly(this,  \"" + usuario.email + "\")' onchange='activarEdicion(this, \"" + usuario.id + "\")'></td>";
                    str += "<td><select name='rol' id='rol_" + usuario.id + "' class='rol' onchange='activarEdicion(this, \"" + usuario.id + "\")'>";
                    roles.forEach(function (rol) {
                        if (rol.id !== 1 && usuario.id_rol !== 1) {
                            str += "<option value='" + rol.id + "'";
                            if (rol.id === usuario.id_rol) {
                                str += " selected";
                            }
                            str += ">" + rol.nombre + "</option>";
                        }
                    });
                    str += "</select></td>";
                    str += '<td><input type="checkbox" onclick="guardarEstadosCheckbox()" class="checkbox-usuaiors" name="pedidos" value="' + usuario.id + '"';
                    // Restaurar el estado del checkbox
                    if (estadosCheckbox[usuario.id]) {
                        str += ' checked';
                    }
                    str += '></td>';
                    str += "<td><input type='button' id='registrar_" + usuario.id + "' class='btn btn-danger' onclick='eliminarUsuario(" + usuario.id + ")' value='Eliminar'></td>";
                
                }
                str += "</form></tr>";
                tabla += str;
            });
            resultado.innerHTML = tabla;
        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}


// La función ListarEmpresas() ya está definida arriba, así que no la vuelvas a definir.
// La siguiente línea debería ser suficiente para llamar a la función guardarEstadosCheckbox().
guardarEstadosCheckbox();

// ----------------------
// Editar ELEMENTO DE LOS DATOS
// ----------------------

function confirmarEdicion(id) {
    var nombreValue = document.getElementById('nombre_' + id).value;
    var apellidosValue = document.getElementById('apellidos_' + id).value;
    var emailValue = document.getElementById('email_' + id).value;
    var rolValue = document.getElementById('rol_' + id).value;

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
            formdata.append('apellidos', apellidosValue);
            formdata.append('email', emailValue);
            formdata.append('rol', rolValue);
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/estado');
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




// ----------------------
// ELIMINAR ELEMENTO (BOTÓN ROJO DEL LISTADO)
// ----------------------

function eliminarUsuario(id) {
    var nombreValue = document.getElementById('nombre_' + id).value;
    Swal.fire({
        title: '¿Está seguro de eliminar a ' + nombreValue + '?',
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
            ajax.open('POST', '/eliminar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText == "ok") {
                        ListarEmpresas('', '', '');
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



// Seleccion multiple, eliminar
function selectmuldel() {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.isConfirmed) {

    const checkboxes = document.querySelectorAll('.checkbox-usuaiors');
    const valoresSeleccionados = [];

    // console.log(checkboxes);
    // console.log(valoresSeleccionados);

    // Recorer los checkbox
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            // almacenar el value de los checkbox
            valoresSeleccionados.push(checkbox.value);
        }
    });

    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    valoresSeleccionados.forEach(function (valor) {
        formdata.append('id[]', valor);
        // console.log(valor);
    });

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/eliminar');
    ajax.onload = function () {
        if (ajax.status === 200) {
            if (ajax.responseText == "ok") {
                ListarEmpresas('', '', '');
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