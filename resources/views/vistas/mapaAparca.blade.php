<?php
$variable_de_sesion = session('id') ?? null;
$pago = session('pago') ?? null;
$rol = session('rol') ?? null;

if ($variable_de_sesion !== null && $pago === 'si' && $rol == 3) {
    // Código que quieres ejecutar si las condiciones se cumplen
} else {
    echo "<script>
        window.location.href = '/';
    </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mapa con Leaflet y AJAX</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="./css/mapaDeAparca.css">
</head>
<body>
    <div class="navbar">
        <a href="/trabajador" class="botonNo"><img src="./img/volver.svg" width="40px"></a>
        <input type="search">
        <div class="hamburguesa" onclick="toggleUbicaciones()">☰</div>
    </div>
    <div id="map"></div>
    <div id="ubicaciones" class="ubicaciones"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="./js/mapaDeAparca.js"></script>
{{--     <script>
        var originalMarkers = []; // Variable para almacenar los marcadores originales
        var map = L.map('map').setView([40.416775, -3.703790], 14); // Coordenadas centradas en España

        // Añadir un mapa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Definir íconos personalizados
        var parkingIcon = L.icon({
            iconUrl: './img/parkinM.svg', // Reemplaza con la ruta real a tu ícono de parking
            iconSize: [38, 38], // tamaño del ícono
            iconAnchor: [19, 38], // punto del ícono que se corresponderá con la ubicación del marcador
            popupAnchor: [0, -38] // punto desde el que se abrirá el popup en relación al iconAnchor
        });

        var currentLocationIcon = L.icon({
            iconUrl: './img/yo.svg', // Reemplaza con la ruta real a tu ícono de ubicación actual
            iconSize: [38, 38], // tamaño del ícono
            iconAnchor: [19, 38], // punto del ícono que se corresponderá con la ubicación del marcador
            popupAnchor: [0, -38] // punto desde el que se abrirá el popup en relación al iconAnchor
        });

        var currentLocationObjetivo = L.icon({
            iconUrl: './img/ubiEn.png', // Reemplaza con la ruta real a tu ícono de ubicación actual
            iconSize: [38, 38], // tamaño del ícono
            iconAnchor: [19, 38], // punto del ícono que se corresponderá con la ubicación del marcador
            popupAnchor: [0, -38] // punto desde el que se abrirá el popup en relación al iconAnchor
        });

    var routingControl; // Variable para almacenar la referencia al control de enrutamiento

    // function showCurrentLocation() {
    //     if (navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(function(position) {
    //             var lat = position.coords.latitude;
    //             var lng = position.coords.longitude;

    //             // Añadir un marcador en la ubicación actual
    //             var currentLocationMarker = L.marker([lat, lng], { icon: currentLocationIcon }).addTo(map)
    //                 .openPopup();
                
    //             // Centrar el mapa y hacer zoom solo en la ubicación actual
    //             // map.setView([lat, lng], 10);

    //             // Llamar a la función com para dibujar la ruta a partir de la ubicación actual
    //             updateRoute(lat, lng);

    //         }, function(error) {
    //             console.error('Error al obtener la ubicación: ' + error.message);
    //         });
    //     } else {
    //         alert('La geolocalización no está soportada por este navegador.');
    //     }
    // }

    function showCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            // Añadir un marcador en la ubicación actual
            var currentLocationMarker = L.marker([lat, lng], { icon: currentLocationIcon }).addTo(map)
                .openPopup();
            
            // Centrar el mapa y hacer zoom solo en la ubicación actual
            map.setView([lat, lng], 13);
            // updateRoute(lat, lng);

        }, function(error) {
            console.error('Error al obtener la ubicación: ' + error.message);
        });
    } else {
        alert('La geolocalización no está soportada por este navegador.');
    }
}

    // Llamar a la función showCurrentLocation() cada 5 segundos
    setInterval(showCurrentLocation, 5000);

    function updateRoute(lat, lng) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/menCor2');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var coordinates = JSON.parse(xhr.responseText);
                var destinationLat = coordinates.latitudC;
                var destinationLng = coordinates.longitudC;

                var destinationPoint = L.latLng(destinationLat, destinationLng);

                // Si ya hay un control de enrutamiento, actualizar los puntos de inicio y destino
                if (routingControl) {
                    routingControl.setWaypoints([
                        L.latLng(lat, lng),
                        destinationPoint
                    ]);
                } else {
                    // Si no hay un control de enrutamiento, crear uno nuevo
                    routingControl = L.Routing.control({
                        waypoints: [
                            L.latLng(lat, lng),
                            destinationPoint
                        ],
                        createMarker: function(i, waypoint) {
                            // Crear marcador con la clase currentLocationObjetivo para el destino
                            if (i === 1) {
                                return L.marker(waypoint.latLng, { icon: currentLocationObjetivo });
                            }
                        },
                        routeWhileDragging: false,
                        addWaypoints: false,
                        draggableWaypoints: false,
                        fitSelectedRoutes: true, // Ajustar el mapa para mostrar la ruta completa
                        lineOptions: {
                            styles: [{ color: 'blue', opacity: 0.6, weight: 4 }]
                        }
                    }).addTo(map);
                }

            } else {
                console.error('Error al obtener las coordenadas:', xhr.responseText);
            }
        };
        xhr.onerror = function() {
            console.error('Error de red al obtener las coordenadas');
        };
        xhr.send();
    }



    // Realizar una solicitud AJAX para obtener los datos de las plazas de aparcamiento
var xhr = new XMLHttpRequest();
xhr.open('GET', '/mapaT');
xhr.onload = function() {
    if (xhr.status === 200) {
        var plazas = JSON.parse(xhr.responseText);

        var ubicacionesDiv = document.getElementById('ubicaciones');
        var ubicacionesList = document.createElement('ul');

        plazas.forEach(function(plaza) {
            if (plaza.latitud && plaza.longitud) {
                var marker = L.marker([plaza.latitud, plaza.longitud], { icon: parkingIcon }).addTo(map)
                    .bindPopup('<b>' + plaza.nombre + '</b>')
                    .on('click', function(e) {
                        map.flyTo([plaza.latitud, plaza.longitud], 16, {
                            duration: 2 // Duración de la animación en segundos
                        });
                    });

                originalMarkers.push(marker); // Almacenar el marcador original

                var ubicacionItem = document.createElement('li');
                ubicacionItem.textContent = plaza.nombre;
                ubicacionItem.addEventListener('click', function() {
                    showRouteToParking(plaza.latitud, plaza.longitud);
                });
                ubicacionesList.appendChild(ubicacionItem);
            }
        });

        ubicacionesDiv.innerHTML = '';
        ubicacionesDiv.appendChild(ubicacionesList);
    } else {
        console.error('Error al cargar los datos de las plazas de aparcamiento');
    }
};
xhr.send();

// Función para mostrar la ruta desde la ubicación actual hasta la plaza seleccionada
function showRouteToParking(targetLat, targetLng) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            if (typeof routingControl !== 'undefined') {
                map.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(lat, lng),
                    L.latLng(targetLat, targetLng)
                ],
                createMarker: function(i, waypoint) {
                    // Crear marcador con la clase currentLocationObjetivo para el destino
                    if (i === 1) {
                        return L.marker(waypoint.latLng, { icon: currentLocationObjetivo });
                    } else {
                        return L.marker(waypoint.latLng, { icon: currentLocationIcon });
                    }
                },
                routeWhileDragging: false,
                addWaypoints: false,
                draggableWaypoints: false,
                fitSelectedRoutes: true, // Ajustar el mapa para mostrar la ruta completa
                lineOptions: {
                    styles: [{ color: 'blue', opacity: 0.6, weight: 4 }]
                }
            }).addTo(map);

        }, function(error) {
            console.error('Error al obtener la ubicación: ' + error.message);
        });
    } else {
        alert('La geolocalización no está soportada por este navegador.');
    }
}

// Llamar a la función showCurrentLocation() cada 5 segundos
setInterval(showCurrentLocation, 5000);

// Llamar a la función para mostrar la ubicación actual al cargar la página
showCurrentLocation();


        function toggleUbicaciones() {
            var ubicaciones = document.getElementById('ubicaciones');
            if (ubicaciones.classList.contains("mostrar")) {
                document.getElementById('ubicaciones').style.display = "block";
                ubicaciones.classList.remove("mostrar");
            } else {
                document.getElementById('ubicaciones').style.display = "none";
                ubicaciones.classList.add("mostrar");
            }
        }

        function searchLocation() {
            var query = document.querySelector('input[type="search"]').value.toLowerCase();

            // Mostrar u ocultar los marcadores según la búsqueda
            originalMarkers.forEach(function(marker) {
                var nombre = marker.getPopup().getContent().toLowerCase();

                if (nombre.includes(query)) {
                    marker.addTo(map);
                } else {
                    map.removeLayer(marker);
                }
            });
        }

        // Asignar la función searchLocation al evento input del campo de búsqueda
        document.querySelector('input[type="search"]').addEventListener('input', searchLocation);

        // Llamar a la función para mostrar la ubicación actual
        showCurrentLocation();
        // Llamar a la función showCurrentLocation() cada 5 segundos
        // setInterval(showCurrentLocation, 5000);
    </script> --}}
</body>
</html>
