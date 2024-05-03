/* Alternar cont-crud expandir contraer */

document.getElementById('menuToggle').addEventListener('click', function() {
    var contCrud = document.getElementById('cont-crud');
    contCrud.classList.toggle('expanded'); 
});

/* Mapa */

var map = L.map('map').setView([41.3497528271445, 2.1080974175773473], 18);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

L.marker([41.34971957556145, 2.1076759794296467]).addTo(map);

map.on('click', function(e) {
    var latlng = e.latlng;
    L.popup()
        .setLatLng(latlng)
        .setContent("Latitud: " + latlng.lat + "<br>" + "Longitud: " + latlng.lng)
        .openOn(map);
});

