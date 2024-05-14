document.addEventListener("DOMContentLoaded", function () {
    // Mostrar/ocultar formulario
    var nav = document.getElementById('add-user');
    var submenu = document.getElementById('submenu');

    nav.addEventListener('click', function () {
        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
    });

    // Quitar readonly del formulario
    function quitarReadOnly(input, textooriginal) {
        input.removeAttribute('readonly'); // Eliminamos el atributo readonly
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

    // Guardar estados de los checkboxes
    const estadosCheckbox = {};

    function guardarEstadosCheckbox() {
        const checkboxes = document.querySelectorAll('.checkbox-usuaiors');
        checkboxes.forEach(function (checkbox) {
            estadosCheckbox[checkbox.value] = checkbox.checked;
        });
        // console.log(estadosCheckbox);
    }

    // Escuchar evento para actualizar el formulario de filtro
    const inputNombre = document.getElementById('nombre');
    inputNombre.addEventListener("keyup", actualizarFiltro);

    let filtroRol = '';

    function actualizarFiltro() {
        const nombre = inputNombre.value;
        ListarEmpresas(nombre, filtroRol, '2');
    }

    document.getElementById('filtroRol').addEventListener('change', function (event) {
        const valorSeleccionado = event.target.value;
        filtroRol = valorSeleccionado;
        actualizarFiltro();
    });

    // Contador de usuarios
    var totalUsuarios = document.getElementById('resultado').getElementsByTagName('tr').length;
    document.getElementById('totalUsuarios').innerText = totalUsuarios;

    // Selector de cantidad de usuarios por página
    document.getElementById('selectPaginacion').addEventListener('change', function(event) {
        actualizarFiltro();
    });

    // Listar empresas al cargar la página
    ListarEmpresas('', '', 1);

    var usuariosPorPagina = 5;
    var paginaActual = 1;

    function ListarEmpresas(nombre, filtroRol, filtro = 1) {
        var resultado = document.getElementById('resultado');
        var formdata = new FormData();
        var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
        formdata.append('_token', csrfToken);
        formdata.append('nombre', nombre);
        formdata.append('rol', filtroRol);

        var ajax = new XMLHttpRequest();
        ajax.open('POST', '/Listarempleados');
        ajax.onload = function () {
            if (ajax.status == 200) {
                var json = JSON.parse(ajax.responseText);
                var usuarios = json.usuarios;
                var roles = json.roles;
                
                // Contador de usuarios
                document.getElementById('totalUsuarios').innerText = usuarios.length;

                // Selector de cantidad de usuarios por página
                usuariosPorPagina = parseInt(document.getElementById('selectPaginacion').value);

                // Paginación
                var inicio = (paginaActual - 1) * usuariosPorPagina;
                var fin = inicio + usuariosPorPagina;
                var usuariosPaginados = usuarios.slice(inicio, fin);

                // Construcción de la tabla de usuarios
                var tabla = '';
                usuariosPaginados.forEach(function (usuario) {
                    // Código para construir filas de la tabla
                });
                resultado.innerHTML = tabla;

                agregarControlesPaginacion(usuarios.length);
            } else {
                resultado.innerText = 'Error';
            }
        }
        ajax.send(formdata);
    }

    function agregarControlesPaginacion(totalUsuarios) {
        var totalPaginas = Math.ceil(totalUsuarios / usuariosPorPagina);
        var paginacionHTML = '';
        for (var i = 1; i <= totalPaginas; i++) {
            paginacionHTML += `<button onclick="cambiarPagina(${i})">${i}</button>`;
        }
        document.getElementById('paginacion').innerHTML = paginacionHTML;
    }

    function cambiarPagina(numeroPagina) {
        paginaActual = numeroPagina;
        ListarEmpresas('', '', '');
    }

    guardarEstadosCheckbox();

    // Editar elemento de los datos
    function confirmarEdicion(id) {
        var nombreValue = document.getElementById('nombre_' + id).value;
        var apellidosValue = document.getElementById('apellidos_' + id).value;
        var emailValue = document.getElementById('email_' + id).value;
        var rolValue = document.getElementById('rol_' + id).value;

        Swal.fire({
            title: '¿Está seguro de editar a ' + nombreValue + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
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
                            title: 'No se pudo cambiar a ' + nombreValue
                        });
                    }
                }
                ajax.send(formdata);
            }
        })
    }

    // Eliminar elemento (botón rojo del listado)
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
            title: '¿Está seguro de eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
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

    // Registrar usuario
    var registrar = document.getElementById('registrar');
    registrar.addEventListener("click", () => {
        var form = document.getElementById('formnewuser');
        var formdata = new FormData(form);
        var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
        formdata.append('_token', csrfToken);

        var ajax = new XMLHttpRequest();
        ajax.open('POST', '/registrar');

        ajax.onload = function () {
            if (ajax.status === 200) {
                if (ajax.responseText == "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registrado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    ListarEmpresas('', '', '');
                }
            } else {
                respuesta_ajax.innerText = 'Error';
            }
        }
        ajax.send(formdata);
    });
});
