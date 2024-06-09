// Mostrar formulario oculto
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
    if (input.value !== textooriginal) {
        boton.setAttribute('onclick', 'confirmarEdicion(' + id + ')');
        boton.classList.remove('btn-outline-danger');
        boton.classList.add('btn', 'btn-outline-success');
        boton.innerHTML = '<i class="fa-solid fa-check"></i>';
        input.style.border = "1px solid black";
        input.style.backgroundColor = "white";
    } else {
        boton.setAttribute('onclick', 'eliminarempresas(' + id + ')');
        boton.classList.remove('btn-outline-success');
        boton.classList.add('btn', 'btn-outline-danger');
        boton.innerHTML = '<i class="fa-solid fa-trash"></i>';
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
}

// ESCUCHAR EVENTO ACTUALIZAR FORMULARIO DEL FILTRO
document.getElementById('nombre').addEventListener("keyup", () => {
    const valor = document.getElementById('nombre').value;
    ListarPersonalEmpresas(valor);
});

ListarPersonalEmpresas('');

function ListarPersonalEmpresas(valor) {
    var resultado = document.getElementById('resultado');
    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('nombre', valor);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/adminempresas');
    ajax.onload = function () {
        if (ajax.status == 200) {
            var json = JSON.parse(ajax.responseText);
            let tabla = '';
            json.forEach(function (empresa) {
                if (empresa.id !== 11) {
                    let str = "<tr>";
                    str += "<form action='' method='post' id='frmeditar'>";
                    str += "<input type='hidden' name='idp' id='idp' value='" + empresa.id + "'>";
                    str += "<td><input type='text' style='border:none; text-align:left; background-color: transparent' name='nombre' id='nombre_" + empresa.id + "' value='" + empresa.nombre + "' readonly ondblclick='quitarReadOnly(this, \"" + empresa.nombre + "\")' onchange='activarEdicion(this, \"" + empresa.id + "\")'></td>";
                    str += '<td class="text-center"><input type="checkbox" onclick="guardarEstadosCheckbox()" class="checkbox-usuaiors" name="pedidos" value="' + empresa.id + '"';

                    if (estadosCheckbox[empresa.id]) {
                        str += ' checked';
                    }
                    str += '></td>';
                    str += "<td class='text-center'><button type='button' id='registrar_" + empresa.id + "' class='btn btn-outline-danger' onclick='eliminarempresas(" + empresa.id + ")'><i class='fa-solid fa-trash'></i></button></td>";
                    str += "</form></tr>";

                    tabla += str;
                }
            });
            resultado.innerHTML = tabla;
        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}

guardarEstadosCheckbox();

function confirmarEdicion(id) {
    var nombreValue = document.getElementById('nombre_' + id).value;

    Swal.fire({
        title: '¿Está seguro de editar a ' + nombreValue + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('idp', id);
            formdata.append('nombre', nombreValue);
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/adminempresaseditar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText === "ok") {
                        ListarPersonalEmpresas('');
                        Swal.fire({
                            icon: 'success',
                            title: nombreValue,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        ListarPersonalEmpresas('');
                        Swal.fire({
                            icon: 'error',
                            title: nombreValue + " ya existe",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            }
            ajax.send(formdata);
        }
    });
}

function eliminarempresas(id) {
    var nombreValue = document.getElementById('nombre_' + id).value;
    Swal.fire({
        title: '¿Está seguro de eliminar a ' + nombreValue + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        position: 'top-end',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('id', id);
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/adminempresaseliminar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText == "ok") {
                        Swal.fire({
                            icon: 'success',
                            position: 'top-end',
                            title: 'Empresa eliminada',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        ListarPersonalEmpresas('');
                    }
                }
            }
            ajax.send(formdata);
        }
    });
}

function selectmuldel() {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí!',
        position: 'top-end',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const checkboxes = document.querySelectorAll('.checkbox-usuaiors');
            const valoresSeleccionados = [];

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    valoresSeleccionados.push(checkbox.value);
                }
            });

            var formdata = new FormData();
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            valoresSeleccionados.forEach(function (valor) {
                formdata.append('id[]', valor);
            });

            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/adminempresaseliminar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText == "ok") {
                        ListarPersonalEmpresas('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Empresas seleccionadas eliminadas',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            }
            ajax.send(formdata);
        }
    });
}

document.getElementById('registrar').addEventListener('click', function () {
    var nombre = document.getElementById('nombreuser').value;
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var formdata = new FormData();
    formdata.append('_token', csrfToken);
    formdata.append('nombreuser', nombre);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/adminempresasregistrar', true);
    ajax.onload = function () {
        if (ajax.status == 200) {
            if (ajax.responseText.trim() === "ok") {
                ListarPersonalEmpresas('');
                $('#registerModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    position: 'top-end',
                    title: 'Registrado',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'El nombre ya existe',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    };
    ajax.send(formdata);
});
