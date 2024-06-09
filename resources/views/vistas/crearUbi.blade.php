@php
use App\Models\tbl_ubicaciones;
use Illuminate\Support\Facades\DB;


$ubicaciones = DB::table('tbl_ubicaciones')
    ->join('tbl_empresas', 'tbl_ubicaciones.empresa', '=', 'tbl_empresas.id')
    ->where('tbl_empresas.id', session('empresa'))
    ->select('tbl_ubicaciones.*', 'tbl_empresas.nombre as nombre_empresa')
    ->get();
@endphp
@extends('layouts.plantilla_header')
<?php
$variable_de_sesion = session('id') ?? null;
$pago = session('pago') ?? null;
$rol = session('rol') ?? null;

if ($variable_de_sesion !== null && $pago === 'si' && $rol == 2) {
    // Código que quieres ejecutar si las condiciones se cumplen
} else {
    echo "<script>
        window.location.href = '/';
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/hacerUbis.css') }}">
    <title>Ubicaciones | MyControlPark</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="custom-bg"> <!-- Agregar la clase custom-bg para el color de fondo personalizado -->
        {{-- NAVBAR --}}
        <header>
            <nav>
                <ul class="nav-left">
                    <li><img src="{{ asset('img/logo.png') }}" alt="Logo"></li>
                    <li><a href="{{ route('gestEmpleados') }}">Empleados</a></li>
                    <li><a href="{{ 'reservas' }}">Reservas</a></li>
                    <li><a href="{{ 'mapa' }}">Mapa</a></li>
                    <li><a href="{{ 'historial' }}">Historial de reservas</a></li>
                    <li class="active">Añadir Ubicaciones</li>
                </ul>

                <ul class="nav-right">
                    <li>{{ session('nombre') }}</li>

                    @if (session('nombre_empresa'))
                        <li>{{ session('nombre_empresa') }}</li>
                    @else
                        <li>Empresa no asignada</li>
                    @endif

                    <li id="ce"><a href="{{ route('logout') }}">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>

        {{-- BOTONES --}}
        <div id="cont_botones">
            {{-- REGISTRAR UBICACIÓN --}}
            <button type="button" class="btn btn-outline-dark" id="abrirModal" onclick="mas()">Añadir ubicación</button>

            {{-- BOTÓN PARA VOLVER A LA PÁGINA PRINCIPAL POR DEFECTO --}}
            <button type="button" class="btn btn-dark" style="border-radius: 5px;">
                <a href="{{ '/yes' }}" style="text-decoration: none; color: white;">Quitar filtros</a>
            </button>
        </div>
    
        <form class="row justify-content-center col-md-6 bg-light tablas" style="display: none; position:fixed; z-index:10;" id="mas">
        <!-- Contenido del formulario de agregar ubicación -->
        <div class="form-group">
            <label for="nombre_sitio">Nombre del Sitio:</label>
            <input type="text" id="nombre_sitio2" name="nombre_sitio" class="form-control">
        </div>
        <div class="form-group">
            <label for="calle">Calle:</label>
            <input type="text" id="calle2" name="calle" class="form-control">
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad2" name="ciudad" class="form-control">
        </div>
        <div class="form-group">
            <label for="latitud">Latitud:</label>
            <input type="text" id="latitud2" name="latitud" class="form-control">
        </div>
        <div class="form-group">
            <label for="longitud">Longitud:</label>
            <input type="text" id="longitud2" name="longitud" class="form-control">
        </div>
        <div class="btn-group" role="group" aria-label="Botones de acción">
            <button type="button" onclick="agregarUbicacion()" class="btn btn-primary">Enviar</button>
            <button type="button" onclick="cerrar()" class="btn btn-danger">Cancelar</button>
        </div>
    </form>

    <form id="edi" style="display: none; position:fixed; z-index:10;" class="row justify-content-center col-md-6 bg-light tablas">
        <!-- Contenido del formulario de editar ubicación -->
        <input type="hidden" id="idU" name="nombre_empresa" value="">
        <div class="form-group">
            <label for="nombre_sitio">Nombre del Sitio:</label>
            <input type="text" id="nombre_sitio" name="nombre_sitio" class="form-control">
        </div>
        <div class="form-group">
            <label for="calle">Calle:</label>
            <input type="text" id="calle" name="calle" class="form-control">
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" class="form-control">
        </div>
        <div class="form-group">
            <label for="latitud">Latitud:</label>
            <input type="text" id="latitud" name="latitud" class="form-control">
        </div>
        <div class="form-group">
            <label for="longitud">Longitud:</label>
            <input type="text" id="longitud" name="longitud" class="form-control">
        </div>
        <div class="btn-group" role="group" aria-label="Botones de acción">
            <button type="button" onclick="ediUbi()" class="btn btn-primary">Enviar</button>
            <button type="button" onclick="cerrar()" class="btn btn-danger">Cancelar</button>
        </div>
              
    </form>
    <div class="container mt-5">
        <div class="input-group mb-3">
            <input type="search" id="lupa" class="form-control" placeholder="Buscar ubicación">
            <div class="input-group-append">
                <button onclick="buscar()" class="btn btn-outline-secondary" type="button">Buscar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre del Sitio</th>
                    <th>Calle</th>
                    <th>Ciudad</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody id="mostrarU">
                @foreach ($ubicaciones as $ubicacion)
                <tr>
                    <td>{{ $ubicacion->nombre_sitio }}</td>
                    <td>{{ $ubicacion->calle }}</td>
                    <td>{{ $ubicacion->ciudad }}</td>
                    <td>{{ $ubicacion->latitud }}</td>
                    <td>{{ $ubicacion->longitud }}</td>
                    <td><button onclick="editar('{{ $ubicacion->id }}', '{{ $ubicacion->empresa }}', '{{ $ubicacion->nombre_sitio }}', '{{ $ubicacion->calle }}', '{{ $ubicacion->ciudad }}', '{{ $ubicacion->latitud }}', '{{ $ubicacion->longitud }}')" class="btn btn-primary">Editar</button></td>                    
                    <td><button onclick="eliminar({{ $ubicacion->id }})" class="btn btn-danger">Eliminar</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function cerrar() {
    document.getElementById('mas').style.display="none";
    document.getElementById('edi').style.display="none";
}

function eliminar(id) {
    Swal.fire({
        title: "¡Aviso!",
        text: "¿Seguro que quieres eliminar esta ubicacion?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí"
    }).then((result) => {
        if (result.isConfirmed) {
            var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
            var formdata = new FormData();
            formdata.append('id', id);
            formdata.append('_token', csrf_token);
            // Crear instancia de XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configurar la solicitud
            xhr.open("POST", "/eliminarUbica", true);
            // xhr.setRequestHeader("Content-Type", "application/json");

            // Manejar la respuesta de la solicitud
            xhr.onload = function () {
                if (xhr.status === 200) {
                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "¡La ubicacion ha sido eliminada!",
                        icon: "success"
                    });
                    // Aquí puedes hacer algo después de eliminar la subincidencia, si es necesario
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Ha habido un error en la eliminacion",
                        icon: "error"
                    });
                    console.log('Error al crear tipo de incidencia:', xhr.responseText);        
                }
            };

            // Manejar errores de red
            xhr.onerror = function () {
                console.error('Error de red al intentar eliminar la subincidencia.');
                Swal.fire({
                    title: "Error",
                    text: "Ha habido un error en la eliminacion",
                    icon: "error"
                });
            };

            // Enviar la solicitud con el ID de la subincidencia como cuerpo
            xhr.send(formdata);
        }
    });
}

function editar(id, nombre_empresa, nombre_sitio, calle, ciudad, latitud, longitud) {
    document.getElementById('edi').style.display="block";
    document.getElementById('idU').value = id;
    document.getElementById('nombre_sitio').value = nombre_sitio;
    document.getElementById('calle').value = calle;
    document.getElementById('ciudad').value = ciudad;
    document.getElementById('latitud').value = latitud;
    document.getElementById('longitud').value = longitud;
    document.getElementById('mas').style.display="none";
}
function ediUbi() {
    var nombre_empresa = document.getElementById('nombre_empresa');
    var nombre_sitio = document.getElementById('nombre_sitio');
    var calle = document.getElementById('calle');
    var ciudad = document.getElementById('ciudad');
    var latitud = document.getElementById('latitud');
    var longitud = document.getElementById('longitud');
    var valido = false;

    // Validación del nombre del sitio
    if (nombre_sitio.value.trim() === '') {
        nombre_sitio.classList.add('is-invalid');
        valido = true;
    } else {
        nombre_sitio.classList.remove('is-invalid');
    }

    // Validación de la calle
    if (calle.value.trim() === '') {
        calle.classList.add('is-invalid');
        valido = true;
    } else {
        calle.classList.remove('is-invalid');
    }

    // Validación de la ciudad
    if (ciudad.value.trim() === '') {
        ciudad.classList.add('is-invalid');
        valido = true;
    } else {
        ciudad.classList.remove('is-invalid');
    }

    // Validación de la latitud
    if (latitud.value.trim() === '') {
        latitud.classList.add('is-invalid');
        valido = true;
    } else {
        latitud.classList.remove('is-invalid');
    }

    // Validación de la longitud
    if (longitud.value.trim() === '') {
        longitud.classList.add('is-invalid');
        valido = true;
    } else {
        longitud.classList.remove('is-invalid');
    }

    if (valido == false) {
        enEdi2();
    }
}

function mas(){
    document.getElementById('mas').style.display="block";
}

function enEdi2() {
    document.getElementById('edi').style.display="none";
    var id = document.getElementById('idU').value;
    var nombre_sitio = document.getElementById('nombre_sitio').value;
    var calle = document.getElementById('calle').value;
    var ciudad = document.getElementById('ciudad').value;
    var latitud = document.getElementById('latitud').value;
    var longitud = document.getElementById('longitud').value;

    var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    var formData = new FormData();
    formData.append('id', id);
    formData.append('nombre_sitio', nombre_sitio);
    formData.append('calle', calle);
    formData.append('ciudad', ciudad);
    formData.append('latitud', latitud);
    formData.append('longitud', longitud);
    formData.append('_token', csrf_token);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './editarUbicacion', true);
    xhr.onload = function(){
        if (xhr.status == 200) {
            console.log(xhr.responseText);
            buscar();
        } 
        else {
            Swal.fire({
                title: "Error",
                text: "Datos incorrectos",
                icon: "error"
            });
        }
    }
    xhr.send(formData);

    // Lógica adicional si es necesaria
}

function buscar() {
    var lupa = document.getElementById('lupa').value;
    var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    
    // Crear objeto FormData y agregar los datos
    var formdata = new FormData();
    formdata.append('lupa', lupa);
    formdata.append('_token', csrf_token);
    
    // Crear instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la función de respuesta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Actualizar el contenido de la tabla con la respuesta recibida
                document.getElementById('mostrarU').innerHTML = xhr.responseText;
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Datos incorrectos",
                    icon: "error"
                });
            }
        }
    };
    xhr.onerror = function() {
        // Manejar errores de red u otros errores de solicitud AJAX
        Swal.fire({
            title: "Error",
            text: "Datos incorrectos",
            icon: "error"
        });
    };

    // Establecer el método y la URL del request
    xhr.open("POST", "/buscarUbicaciones", true);
    
    // Enviar el request con los datos del formulario
    xhr.send(formdata);
}

function agregarUbicacion() {
    var nombre_sitio = document.getElementById('nombre_sitio2');
    var calle = document.getElementById('calle2');
    var ciudad = document.getElementById('ciudad2');
    var latitud = document.getElementById('latitud2');
    var longitud = document.getElementById('longitud2');
    var valido = true;

    // Validación del nombre del sitio
    if (nombre_sitio.value.trim() === '') {
        nombre_sitio.classList.add('is-invalid');
        valido = false;
    } else {
        nombre_sitio.classList.remove('is-invalid');
    }

    // Validación de la calle
    if (calle.value.trim() === '') {
        calle.classList.add('is-invalid');
        valido = false;
    } else {
        calle.classList.remove('is-invalid');
    }

    // Validación de la ciudad
    if (ciudad.value.trim() === '') {
        ciudad.classList.add('is-invalid');
        valido = false;
    } else {
        ciudad.classList.remove('is-invalid');
    }

    // Validación de la latitud
    if (latitud.value.trim() === '') {
        latitud.classList.add('is-invalid');
        valido = false;
    } else {
        latitud.classList.remove('is-invalid');
    }

    // Validación de la longitud
    if (longitud.value.trim() === '') {
        longitud.classList.add('is-invalid');
        valido = false;
    } else {
        longitud.classList.remove('is-invalid');
    }

    if (valido) {
        agregarUbicacion2(); // Ejecutar alguna acción si todos los campos son válidos
    }
}

function agregarUbicacion2() {
    // Ocultar el formulario de nuevo registro si es necesario
    // document.getElementById('nuevoFormulario').style.display = "none";
    
    // Obtener los valores de los campos del formulario
    var nombreSitio = document.getElementById('nombre_sitio2').value;
    var calle = document.getElementById('calle2').value;
    var ciudad = document.getElementById('ciudad2').value;
    var latitud = document.getElementById('latitud2').value;
    var longitud = document.getElementById('longitud2').value;
    
    // Obtener el token CSRF
    var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    
    // Crear un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('nombre_sitio', nombreSitio);
    formData.append('calle', calle);
    formData.append('ciudad', ciudad);
    formData.append('latitud', latitud);
    formData.append('longitud', longitud);
    formData.append('_token', csrfToken);
    
    // Crear una nueva solicitud XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/agregarUbicacion', true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Establecer el token CSRF en el encabezado
    
    // Definir la función que manejará la respuesta cuando la solicitud se complete
    xhr.onload = function() {
        if (xhr.status == 200) {
            document.getElementById('mas').style.display="none";
            buscar();
            var nombreSitio = document.getElementById('nombre_sitio2').value='';
            var calle = document.getElementById('calle2').value='';
            var ciudad = document.getElementById('ciudad2').value='';
            var latitud = document.getElementById('latitud2').value='';
            var longitud = document.getElementById('longitud2').value='';
        } else {
            Swal.fire({
                title: "Error",
                text: "Datos incorrectos",
                icon: "error"
            });
        }
    };
    
    // Enviar la solicitud con los datos del formulario
    xhr.send(formData);
}
</script>