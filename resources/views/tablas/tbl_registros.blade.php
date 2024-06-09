<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial de reservas</title>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div>
        <h3 style="margin: 20px 0; font-family: Arial, sans-serif; font-size: 24px; color: #333; padding-left: 15px;">
            Historial de reservas
        </h3>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">
                        <select id="filter_usuario" class="form-select form-select-sm mt-1">
                            <option value="" selected disabled>Responsable</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $usuario->id == request('usuario') ? 'selected' : '' }}>
                                    {{ $usuario->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </th>
                    <th scope="col">Dirección</th>
                    <th scope="col">ID de la reserva</th>
                    <th scope="col">
                        <select id="filter_orden" class="form-select form-select-sm mt-1">
                            <option value="" selected disabled>Fecha</option>
                            <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Más recientes primero</option>
                            <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Más antiguas primero</option>
                        </select>
                    </th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @if ($historial->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No hay registros</td>
                    </tr>
                @else
                    @foreach ($historial as $item)
                        <tr class="clickable-row" data-lat="{{ $item->latitud }}" data-lng="{{ $item->longitud }}">
                            <td>{{ $item->usuario_nombre }}</td>
                            <td>{{ $item->direccion }}</td>
                            <td>{{ $item->id_reserva }}</td>
                            <td>{{ $item->fecha_creacion }}</td>
                            <td>{{ $item->accion }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="d-flex justify-content-between">
            <div>
                <select id="filter_perPage" class="form-select w-auto">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 registros</option>
                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 registros</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 registros</option>
                </select>
            </div>
            <div>
                <select id="pagination_select" class="form-select w-auto">
                    @for ($i = 1; $i <= $historial->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $i == $historial->currentPage() ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <script>
        // Filtrar por nombre de usuario
        document.getElementById('filter_usuario').addEventListener('change', function() {
            var usuario = this.value;
            var url = new URL(window.location.href);
            url.searchParams.set('usuario', usuario);
            window.location.href = url.toString();
        });

        // Ordenar por fecha de creación
        document.getElementById('filter_orden').addEventListener('change', function() {
            var orden = this.value;
            var url = new URL(window.location.href);
            url.searchParams.set('orden', orden);
            window.location.href = url.toString();
        });

        // Filtrar por número de registros por página
        document.getElementById('filter_perPage').addEventListener('change', function() {
            var perPage = this.value;
            var url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            window.location.href = url.toString();
        });

        // Paginación
        document.getElementById('pagination_select').addEventListener('change', function() {
            var page = this.value;
            var url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        });

        // Manejo de click en las filas
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    const lat = this.getAttribute('data-lat');
                    const lng = this.getAttribute('data-lng');
                    const confirmed = confirm('Se va a abrir una pestaña nueva para mostrar la ubicación en Google Maps.');
                    if (confirmed) {
                        const url = `https://www.google.com/maps?q=${lat},${lng}`;
                        window.open(url, '_blank');
                    }
                });
            });
        });
    </script>
</body>

</html>
