document.addEventListener("DOMContentLoaded", function () {
    var nav = document.getElementById('menu');
    var submenu = document.getElementById('submenu');

    nav.addEventListener('click', function () {
        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
    });
});

function quitarReadOnly(input, textooriginal) {
    input.removeAttribute('readonly'); // Eliminamos el evento readonly
    input.removeAttribute('ondblclick');
    input.setAttribute('texto-original', textooriginal); // Guardamos el valor original
}

function activarEdicion(input, id) {
    var textooriginal = input.getAttribute('texto-original');
    var boton = document.getElementById('registrar_' + id);

    if (input.value !== textooriginal) {
        boton.setAttribute('onclick', 'confirmarEdicion(' + id + ')');
        boton.classList.remove('btn-outline-danger');
        boton.classList.add('btn-outline-success');
        boton.innerHTML = '<i class="fa-solid fa-check"></i>';
        input.style.border = "1px solid black";
        input.style.backgroundColor = "white";
    } else {
        boton.setAttribute('onclick', 'eliminarUsuario(' + id + ')');
        boton.classList.remove('btn-outline-success');
        boton.classList.add('btn-outline-danger');
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

const inputNombre = document.getElementById('nombre');
inputNombre.addEventListener("keyup", actualizarFiltro);

let filtroRol = '';

function actualizarFiltro() {
    const nombre = inputNombre.value;
    ListarPersonalEmpresas(nombre, filtroRol, '2');
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('filtroRol').addEventListener('change', function (event) {
        const valorSeleccionado = event.target.value;
        filtroRol = valorSeleccionado;
        actualizarFiltro();
    });
});

ListarPersonalEmpresas('', '', 1);

function ListarPersonalEmpresas(nombre, filtroRol, filtro = 1) {
    var resultado = document.getElementById('resultado');
    var formdata = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('nombre', nombre);
    formdata.append('rol', filtroRol);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/adminclientes');
    ajax.onload = function () {
        if (ajax.status == 200) {
            var json = JSON.parse(ajax.responseText);
            var usuarios = json.usuarios;
            var roles = json.roles;
            var empresas = json.empresas;

            var SelecRoles = document.getElementById('SelecRoles');
            let RolesParaForm = '';
            roles.forEach(function (rol) {
                if (rol.id !== 3 && rol.id !== 1) {
                    RolesParaForm += '<option value="' + rol.id + '"> ' + rol.nombre + '</option>';
                }
            });
            SelecRoles.innerHTML = RolesParaForm;

            var SelecEmpresa = document.getElementById('SelecEmpresa');
            let EmpresasParaForm = '';
            let empresasAsociadas = usuarios.map(usuario => usuario.id_empresa);
            let empresasDisponibles = empresas.filter(empresa => !empresasAsociadas.includes(empresa.id));

            EmpresasParaForm += '<option value="">Seleccione una empresa</option>';
            empresasDisponibles.forEach(function (empresa) {
                EmpresasParaForm += '<option value="' + empresa.id + '"> ' + empresa.nombre + '</option>';
            });
            SelecEmpresa.innerHTML = EmpresasParaForm;

            if (filtro === 1) {
                var filtroRol = document.getElementById('filtroRol');
                let ParaFiltroRoles = '';
                ParaFiltroRoles += '<option value="">Todo</option>';
                roles.forEach(function (rol) {
                    if (rol.id !== 3) {
                        ParaFiltroRoles += '<option value="' + rol.id + '"> ' + rol.nombre + '</option>';
                    }
                });
                filtroRol.innerHTML = ParaFiltroRoles;
            }

            let tabla = '';
            usuarios.forEach(function (usuario) {
                if (usuario.id_empresa !== 11) {
                    // let str = "<table>";
                    let str = "<tr>";
                    // str += "<form action='' method='post' id='frmeditar'>";
                    str += "<input type='hidden' name='idp' id='idp' value='" + usuario.id + "'>";
                    str += "<td><input type='text' style='border:none; text-align:left; background-color: transparent' name='nombre' id='nombre_" + usuario.id + "' value='" + usuario.nombre + "' readonly ondblclick='quitarReadOnly(this, \"" + usuario.nombre + "\")' onchange='activarEdicion(this, \"" + usuario.id + "\")'></td>";
                    str += "<td><input type='text' style='border:none; text-align:left; background-color: transparent' name='apellidos' id='apellidos_" + usuario.id + "' value='" + usuario.apellidos + "' readonly ondblclick='quitarReadOnly(this, \"" + usuario.apellidos + "\")' onchange='activarEdicion(this, \"" + usuario.id + "\")'></td>";
                    str += "<td><input type='text' style='border:none; text-align:left; width: 450px; background-color: transparent' value='" + usuario.email + "' readonly></td>";
                    str += "<td><input type='text' style='border:none; text-align:left; background-color: transparent' value='" + usuario.nom_rol + "' readonly></td>";
                    str += "<td><select name='rol' id='empresa_" + usuario.id + "' class='rol form-control' onchange='activarEdicion(this, \"" + usuario.id + "\")'>";
                    empresas.forEach(function (empresa) {
                        var empresaAsociada = false;
                        usuarios.forEach(function (usuario) {
                            if (empresa.id === usuario.id_empresa) {
                                empresaAsociada = true;
                            }
                        });

                        if (empresa.id === usuario.id_empresa) {
                            str += "<option value='" + empresa.id + "'";
                            str += " selected"; str += ">" + empresa.nombre + "</option>";
                        }
                        if (!empresaAsociada) {
                            str += "<option value='" + empresa.id + "'>" + empresa.nombre + "</option>";
                        }
                    });
                    str += "</select></td>";
                    str += '<td class="text-center"><input type="checkbox" onclick="guardarEstadosCheckbox()" class="checkbox-usuaiors" name="pedidos" value="' + usuario.id + '"';
                    if (estadosCheckbox[usuario.id]) {
                        str += ' checked';
                    }
                    str += '></td>';
                    str += "<td class='text-center'><button id='registrar_" + usuario.id + "' class='btn btn-outline-danger' onclick='eliminarUsuario(" + usuario.id + ")'><i class='fa-solid fa-trash'></i></button></td>";
                    // str += "</form></tr>";
                    str += "</tr>";
                    // str += "</table>";
                    tabla += str;
                } else {
                    let str = "<tr>";
                    str += "<td><input type='text' style='border:none;  background-color: transparent'value='" + usuario.nombre + "' readonly></td>";
                    str += "<td><input type='text' style='border:none; background-color: transparent'value='" + usuario.apellidos + "' readonly></td>";
                    str += "<td><input type='text' style='border:none; background-color: transparent'value='" + usuario.email + "' readonly ></td>";
                    str += "<td><input type='text' style='border:none;  background-color: transparent'value='" + usuario.nom_rol + "' readonly ></td>";
                    str += "<td><input type='text' style='border:none;  background-color: transparent' value='" + usuario.nom_empresa + "' readonly ></td>";
                    str += "<td></td>";
                    str += "<td></td>";
                    str += "</tr>";
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
    var apellidosValue = document.getElementById('apellidos_' + id).value;
    var empresaValue = document.getElementById('empresa_' + id).value;

    var EmpresaNombre = document.getElementById('empresa_' + id).options[document.getElementById('empresa_' + id).selectedIndex].text.replace(' ', '').trim().toLowerCase();

    Swal.fire({
        title: '¿Está seguro de editar a ' + nombreValue + '?',
        icon: 'warning',
        position: 'top-end',
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
            formdata.append('empresa', empresaValue);
            formdata.append('EmpresaNombre', EmpresaNombre);
            var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
            formdata.append('_token', csrfToken);
            var ajax = new XMLHttpRequest();
            ajax.open('POST', '/admineditar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText === "ok") {
                        actualizarFiltro();
                        Swal.fire({
                            icon: 'success',
                            position: 'top-end',
                            title: `Usuario ${nombreValue} modificado correctamente`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                } else {
                    actualizarFiltro();
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

function eliminarUsuario(id) {
    var nombreValue = document.getElementById('nombre_' + id).value;
    Swal.fire({
        title: '¿Está seguro de eliminar a ' + nombreValue + '?',
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
            ajax.open('POST', '/admineliminar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText == "ok") {
                        actualizarFiltro();
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            position: 'top-end',
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

function selectmuldel() {
    Swal.fire({
        title: '¿Esta seguro de eliminar?',
        icon: 'warning',
        position: 'top-end',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'NO'
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
            ajax.open('POST', '/admineliminar');
            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText == "ok") {
                        actualizarFiltro();
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            position: 'top-end',
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

registrar.addEventListener("click", () => {
    var form = document.getElementById('formnewuser');
    var formdata = new FormData(form);
    
    // Itera sobre los pares clave-valor y los imprime en la consola
    formdata.forEach((value, key) => {
        console.log(key + ': ' + value);
    });
    
    var NombreSelect = document.getElementById('SelecEmpresa');
    var selectedEmpresaNombre = NombreSelect.options[NombreSelect.selectedIndex].text.replace(' ', '').trim().toLowerCase();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    formdata.append('nombre_empresa', selectedEmpresaNombre);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', '/adminregistrar');
    ajax.onload = function () {
        if (ajax.status === 200) {
            if (ajax.responseText == "ok") {
                Swal.fire({
                    icon: 'success',
                    position: 'top-end',
                    title: 'Registrado',
                    showConfirmButton: false,
                    timer: 1500
                });
                actualizarFiltro();
                form.reset();
            }
        }
    }
    ajax.send(formdata);
});
