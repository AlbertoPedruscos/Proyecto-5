// Alternar cont-crud expandir/contraer
document.getElementById('menuToggle').addEventListener('click', function() {
    var contCrud = document.getElementById('cont-crud');
    contCrud.classList.toggle('expanded'); 
});

// Configurar el mapa con Leaflet
var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Añadir marcadores para cada parking
@if (isset($parkings))
    @foreach ($parkings as $parking)
        L.marker([{{ $parking->latitud }}, {{ $parking->longitud }}]).addTo(map)
            .bindPopup('<b>{{ $parking->nombre }}</b><br>Lat: {{ $parking.latitud }}, Lon: {{ $parking.longitud }}');
    @endforeach
@endif

// Función para mostrar coordenadas cuando se hace clic en el mapa
map.on('click', function(e) {
    var latlng = e.latlng;
    L.popup()
        .setLatLng(latlng)
        .setContent("Latitud: " + latlng.lat + "<br>" + "Longitud: " + latlng.lng)
        .openOn(map);
});

// Funciones para botones de Mostrar, Editar, y Eliminar
function mostrarParking(id) {
    alert("Mostrar información del parking con ID: " + id);
}

function editarParking(id) {
    alert("Editar información del parking con ID: " + id);
}

function eliminarParking(id) {
    if (confirm("¿Estás seguro de que deseas eliminar el parking con ID: " + id + "?")) {
        alert("Eliminar parking con ID: " + id);
    }
}
