var botonHabilitado = true;

document.getElementById('startButton').addEventListener('click', function() {
    var button = document.getElementById('startButton');
    if (button.textContent === 'Iniciar desplazamiento') {
        iniciarRuta('/espia', 'entrada', '¡La ruta ha empezado!', 'startButton');
    } else {
        iniciarRuta('/espia2', 'salida', '¡La ruta ha acabado!', 'startButton');
    }
});

function iniciarRuta(url, accion, mensajeExito, botonId) {
    if (!botonHabilitado) return;

    botonHabilitado = false;
    var button = document.getElementById(botonId);
    button.disabled = true;
    var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var coordenadasUsuario = {
                latitud: position.coords.latitude,
                longitud: position.coords.longitude
            };

            // Enviar las coordenadas al servidor
            var formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('latitud', coordenadasUsuario.latitud);
            formData.append('longitud', coordenadasUsuario.longitud);
            formData.append('acciones', accion);  // Añadir el campo 'acciones'

            var xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onload = function() {
                botonHabilitado = true;
                button.disabled = false;
                if (xhr.status == 200) {
                    console.log('Coordenadas enviadas correctamente.');
                    Swal.fire({
                        title: mensajeExito,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    // Cambiar el texto del botón según la acción
                    if (accion === 'entrada') {
                        button.textContent = 'Detener desplazamiento';
                    } else {
                        button.textContent = 'Iniciar desplazamiento';
                    }
                } else {
                    console.log('Error al enviar las coordenadas:', xhr.responseText);
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al enviar las coordenadas. Inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            };

            xhr.onerror = function(error) {
                botonHabilitado = true;
                button.disabled = false;
                console.error('Error de red al intentar enviar las coordenadas:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error de red. Inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            };

            xhr.send(formData);
        }, function(error) {
            botonHabilitado = true;
            button.disabled = false;
            console.error('Error al obtener la geolocalización:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al obtener la geolocalización. Inténtalo de nuevo.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    } else {
        botonHabilitado = true;
        button.disabled = false;
        console.log('La geolocalización no es compatible con este navegador.');
        Swal.fire({
            title: 'Error',
            text: 'La geolocalización no es compatible con este navegador.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}
