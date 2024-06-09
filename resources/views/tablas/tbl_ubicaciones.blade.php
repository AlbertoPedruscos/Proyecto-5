<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Ubicaciones</title>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <!-- SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        .modal-lg-custom {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>

<body id="fondo_crud">
    <div>
        {{-- CANTIDAD DE UBICACIONES --}}
        <h3 style="margin: 20px 0; font-family: Arial, sans-serif; font-size: 24px; color: #333; padding-left: 15px;">
            Total de ubicaciones: ({{ $totalUbicaciones }})
        </h3>

        {{-- TABLA DE UBICACIONES --}}
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">
                        <select id="filter_nombre" class="form-select form-select-sm mt-1">
                            <option value="" selected disabled>Nombre</option>
                            @foreach ($ubicaciones->unique('nombre_sitio') as $ubicacion)
                                <option value="{{ $ubicacion->nombre_sitio }}">{{ $ubicacion->nombre_sitio }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th scope="col">
                        <select id="filter_ciudad" class="form-select form-select-sm mt-1">
                            <option value="" selected disabled>Ciudad</option>
                            @foreach ($ubicaciones->unique('ciudad') as $ubicacion)
                                <option value="{{ $ubicacion->ciudad }}">{{ $ubicacion->ciudad }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>Calle</th>
                    <th scope="col">
                        <select id="filter_direction" class="form-select form-select-sm">
                            <option value="" selected disabled>Fecha de creación</option>
                            <option value="desc" {{ $orderDirection == 'desc' ? 'selected' : '' }}>Más nuevos
                                primero</option>
                            <option value="asc" {{ $orderDirection == 'asc' ? 'selected' : '' }}>Más antiguos
                                primero</option>
                        </select>
                    </th>
                    <th scope="col" style="width: 150px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($ubicaciones->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron resultados.</td>
                    </tr>
                @else
                    @foreach ($ubicaciones as $ubicacion)
                        <tr>
                            <td>{{ $ubicacion->id }}</td>
                            <td>{{ $ubicacion->nombre_sitio }}</td>
                            <td>{{ $ubicacion->ciudad }}</td>
                            <td>{{ $ubicacion->calle }}</td>
                            <td>{{ $ubicacion->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <!-- Botón para editar empleado -->
                                    <button class="btn btn-outline-warning btn-sm btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $ubicacion->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Formulario para eliminar el usuario -->
                                    <form id="frmEliminar{{ $ubicacion->id }}"
                                        action="{{ route('ubicaciones.destroy', ['id' => $ubicacion->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="eliminarUbicacion({{ $ubicacion->id }})"
                                            class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Modal de edición -->
                                <div class="modal fade" id="editModal{{ $ubicacion->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $ubicacion->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content modal-lg-custom">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $ubicacion->id }}">Editar
                                                    Ubicación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Contenido del formulario de edición -->
                                                <form
                                                    action="{{ route('ubicaciones.update', ['id' => $ubicacion->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="nombre_sitio{{ $ubicacion->id }}"
                                                            class="form-label">Nombre del sitio</label>
                                                        <input type="text" class="form-control"
                                                            id="nombre_sitio{{ $ubicacion->id }}" name="nombre_sitio"
                                                            value="{{ $ubicacion->nombre_sitio }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ciudad{{ $ubicacion->id }}"
                                                            class="form-label">Ciudad</label>
                                                        <input type="text" class="form-control"
                                                            id="ciudad{{ $ubicacion->id }}" name="ciudad"
                                                            value="{{ $ubicacion->ciudad }}"
                                                            placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="calle{{ $ubicacion->id }}"
                                                            class="form-label">Calle</label>
                                                        <input type="text" class="form-control"
                                                            id="calle{{ $ubicacion->id }}" name="calle"
                                                            value="{{ $ubicacion->calle }}"
                                                            placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="latitud{{ $ubicacion->id }}"
                                                            class="form-label">Latitud</label>
                                                        <input type="text" class="form-control"
                                                            id="latitud{{ $ubicacion->id }}" name="latitud"
                                                            value="{{ $ubicacion->latitud }}"
                                                            placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="longitud{{ $ubicacion->id }}"
                                                            class="form-label">Longitud</label>
                                                        <input type="text" class="form-control"
                                                            id="longitud{{ $ubicacion->id }}" name="longitud"
                                                            value="{{ $ubicacion->longitud }}"
                                                            placeholder="Este campo se rellenará automáticamente cuando cliques en el mapa" readonly>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-success"
                                                        onclick="openMapModal({{ $ubicacion->id }})">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                    </button>
                                                    <br>
                                                    <button type="submit"
                                                        class="btn btn-outline-primary mt-2">Guardar cambios</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal para el mapa -->
                                <div class="modal fade" id="mapModal{{ $ubicacion->id }}" tabindex="-1"
                                    aria-labelledby="mapModalLabel{{ $ubicacion->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="mapModalLabel{{ $ubicacion->id }}">
                                                    Seleccionar Ubicación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="map{{ $ubicacion->id }}" style="height: 400px;"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <!-- Imprimir filas vacías si no se llega al número de registros por página -->
                    @if ($ubicaciones->count() < $ubicaciones->perPage())
                        @for ($i = $ubicaciones->count(); $i < $ubicaciones->perPage(); $i++)
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                @endif
            </tbody>
        </table>

        <!-- Paginación y selección de registros por página -->
        <div class="d-flex justify-content-between">
            <div>
                <select id="filter_perPage" class="form-select w-auto">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5 registros</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 registros</option>
                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 registros</option>
                </select>
            </div>
            <div>
                <select id="pagination_select" class="form-select w-auto">
                    @for ($i = 1; $i <= $ubicaciones->lastPage(); $i++)
                        <option value="{{ $i }}"
                            {{ $i == $ubicaciones->currentPage() ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Filtrar por nombre de sitio
        document.getElementById('filter_nombre').addEventListener('change', function() {
            var nombre = this.value;
            window.location.href = `?nombre_sitio=${nombre}`;
        });

        // Filtrar por ciudad
        document.getElementById('filter_ciudad').addEventListener('change', function() {
            var ciudad = this.value;
            window.location.href = `?ciudad=${ciudad}`;
        });

        // Filtrar por número de registros por página
        document.getElementById('filter_perPage').addEventListener('change', function() {
            var perPage = this.value;
            window.location.href = `?perPage=${perPage}`;
        });

        // Paginación
        document.getElementById('pagination_select').addEventListener('change', function() {
            var page = this.value;
            window.location.href = `?page=${page}`;
        });

        // Ordenar por fecha de creación
        document.getElementById('filter_direction').addEventListener('change', function() {
            var orderDirection = this.value;
            window.location.href = `?orderDirection=${orderDirection}`;
        });

        // Eliminar ubicación
        function eliminarUbicacion(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!',
                position: 'top-end'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('frmEliminar' + id).submit();
                }
            });
        }

        // Abrir el modal del mapa
        function openMapModal(id) {
            var mapModal = new bootstrap.Modal(document.getElementById('mapModal' + id));
            mapModal.show();

            // Iniciar el mapa
            document.getElementById('mapModal' + id).addEventListener('shown.bs.modal', function() {
                var map = L.map('map' + id).setView([40.4168, -3.7038], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                var marker;

                map.on('click', function(e) {
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker(e.latlng).addTo(map);
                    var latlng = e.latlng;

                    // Actualizar los valores de los campos de entrada
                    document.getElementById('latitud' + id).value = latlng.lat;
                    document.getElementById('longitud' + id).value = latlng.lng;

                    // Geocodificación inversa para obtener ciudad y calle
                    fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('ciudad' + id).value = data.address.city || data
                                .address.town || data.address.village || '';
                            document.getElementById('calle' + id).value = data.address.road || '';
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        }
    </script>
</body>

</html>
