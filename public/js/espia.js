document.getElementById('startButton').addEventListener('click', function() {
    var intervalo;

    function obtenerCoordenadasYEnviar() {
        var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var coordenadasUsuario = {
                    latitud: position.coords.latitude,
                    longitud: position.coords.longitude
                };

                // Obtener las coordenadas del estacionamiento con id igual a 1
                var coordenadasEstacionamiento = {
                    latitud: 37.12345, // Latitud del estacionamiento
                    longitud: -122.54321 // Longitud del estacionamiento
                };

                // Calcular la distancia entre las coordenadas del usuario y las del estacionamiento
                var distancia = calcularDistancia(coordenadasUsuario, coordenadasEstacionamiento);

                // Si la distancia es menor o igual a 500 metros, detener el intervalo
                if (distancia <= 500) {
                    clearInterval(intervalo);
                    console.log('Usuario dentro del área de 500 metros.');
                }

                // Enviar las coordenadas al servidor
                var formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('latitud', coordenadasUsuario.latitud);
                formData.append('longitud', coordenadasUsuario.longitud);
                
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/espia', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.onload = function() {
                    if (xhr.status == 200) {
                        console.log('Coordenadas enviadas correctamente.');
                    } else {
                        console.log('Error al enviar las coordenadas:', xhr.responseText);
                    }
                };

                xhr.onerror = function(error) {
                    console.error('Error de red al intentar enviar las coordenadas:', error);
                };

                xhr.send(formData);
            });
        } else {
            console.log('La geolocalización no es compatible con este navegador.');
        }
    }

    // Comenzar el envío de coordenadas cada 5 minutos (300000 milisegundos)
    // intervalo = setInterval(obtenerCoordenadasYEnviar, 300000);
    intervalo = setInterval(obtenerCoordenadasYEnviar, 3000);

    // Función para calcular la distancia entre dos puntos (coordenadas)
    function calcularDistancia(coordenadas1, coordenadas2) {
        var radioTierra = 6371000; // Radio de la Tierra en metros
        var deltaLatitud = deg2rad(coordenadas2.latitud - coordenadas1.latitud);
        var deltaLongitud = deg2rad(coordenadas2.longitud - coordenadas1.longitud);
        var a = Math.sin(deltaLatitud / 2) * Math.sin(deltaLatitud / 2) + Math.cos(deg2rad(coordenadas1.latitud)) * Math.cos(deg2rad(coordenadas2.latitud)) * Math.sin(deltaLongitud / 2) * Math.sin(deltaLongitud / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distancia = radioTierra * c;
        return distancia;
    }

    // Función para convertir grados a radianes
    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
});