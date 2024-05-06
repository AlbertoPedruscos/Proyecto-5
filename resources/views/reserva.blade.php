<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Reserva de Vehículo</title>
    <style>
        body{
            background-color: #003459;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: #003459;">
    <div class="container" style=" background-color: #003459; color:white">
        <div class="form-group">
            <label for="nom_cliente" class="form-label">Email:</label>
            <input type="text" class="form-control" id="nom_cliente" name="nom_cliente">
        </div>
        <div class="form-group">
            <label for="matricula" class="form-label">Matrícula:</label>
            <input type="text" class="form-control" id="matricula" name="matricula">
        </div>
        <div class="form-group">
            <label for="marca" class="form-label">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca">
        </div>
        <div class="form-group">
            <label for="modelo" class="form-label">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo">
        </div>
        <div class="form-group">
            <label for="color" class="form-label">Color:</label>
            <input type="text" class="form-control" id="color" name="color">
        </div>
        <div class="form-group">
            <label for="num_telf" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="num_telf" name="num_telf">
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="ubicacion_entrada" class="form-label">Ubicación de Entrada:</label>
            <input type="text" class="form-control" id="ubicacion_entrada" name="ubicacion_entrada">
        </div>
        <div class="form-group">
            <label for="ubicacion_salida" class="form-label">Ubicación de Salida:</label>
            <input type="text" class="form-control" id="ubicacion_salida" name="ubicacion_salida">
        </div>
        <div class="form-group">
            <label for="fecha_entrada" class="form-label">Fecha de Entrada:</label>
            <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada">
        </div>
        <div class="form-group">
            <label for="fecha_salida" class="form-label">Fecha de Salida:</label>
            <input type="datetime-local" class="form-control" id="fecha_salida" name="fecha_salida">
        </div>
        <br>
        <button type="button" class="btn btn-primary" onclick="reservarNuevo()">Enviar</button>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function reservarNuevo() {
        var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
        var nom_cliente = document.getElementById("nom_cliente").value;
        var matricula = document.getElementById("matricula").value;
        var marca = document.getElementById("marca").value;
        var modelo = document.getElementById("modelo").value;
        var color = document.getElementById("color").value;
        var num_telf = document.getElementById("num_telf").value;
        var email = document.getElementById("email").value;
        var ubicacion_entrada = document.getElementById("ubicacion_entrada").value;
        var ubicacion_salida = document.getElementById("ubicacion_salida").value;
        var fecha_entrada = document.getElementById("fecha_entrada").value;
        var fecha_salida = document.getElementById("fecha_salida").value;

        // Crear un FormData y agregar los valores
        var formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('nom_cliente', nom_cliente);
        formData.append('matricula', matricula);
        formData.append('marca', marca);
        formData.append('modelo', modelo);
        formData.append('color', color);
        formData.append('num_telf', num_telf);
        formData.append('email', email);
        formData.append('ubicacion_entrada', ubicacion_entrada);
        formData.append('ubicacion_salida', ubicacion_salida);
        formData.append('fecha_entrada', fecha_entrada);
        formData.append('fecha_salida', fecha_salida);

        // Crear una nueva solicitud XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/reservaO', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        // Definir el evento onload para manejar la respuesta del servidor
        xhr.onload = function() {
            if (xhr.status == 200) {
                // Aquí puedes manejar la respuesta del servidor si es necesario
                console.log(xhr.responseText);
                Swal.fire(
                    'Reservado!',
                    '¡El vehiculo ha sido reservado!',
                    'success'
                );
            } else {
                console.log('Error al realizar la reserva:', xhr.responseText);
            }
        };

        // Definir el evento onerror para manejar errores de red
        xhr.onerror = function(error) {
            console.error('Error de red al intentar realizar la reserva:', error);
        };

        // Enviar la solicitud con el FormData que contiene los datos del formulario y la imagen de la firma
        xhr.send(formData);
    }
</script>
