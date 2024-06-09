<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Empleados</title>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/empleados.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body id="fondo_crud">
    <div>
        {{-- CANTIDAD DE USUARIOS --}}
        <h3 style="margin: 20px 0; font-family: Arial, sans-serif; font-size: 24px; color: #333; padding-left: 15px;">
            Total de usuarios: ({{ $totalEmpleados }})
        </h3>

        <!-- Tabla de empleados -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">
                        <select name="nombre" id="filter_nombre" class="form-select form-select-sm">
                            <option value="" selected disabled>Nombre</option>
                            @foreach ($todosEmpleados->unique('nombre') as $empleadoFiltro)
                                <option value="{{ $empleadoFiltro->nombre }}">{{ $empleadoFiltro->nombre }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th scope="col">Email</th>
                    <th scope="col">
                        <select id="filter_rol" class="form-select form-select-sm mt-1">
                            <option value="" selected disabled>Roles</option>
                            @foreach ($roles as $role)
                                @if ($role->id != 1)
                                    <option value="{{ $role->id }}" {{ $rol == $role->id ? 'selected' : '' }}>
                                        {{ $role->nombre }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </th>
                    <th scope="col">
                        <select id="filter_direction" class="form-select form-select-sm mt-1">
                            <option value="" selected disabled>Fecha de creación</option>
                            <option value="desc" {{ $orderDirection == 'desc' ? 'selected' : '' }}>Más nuevos
                                primero
                            </option>
                            <option value="asc" {{ $orderDirection == 'asc' ? 'selected' : '' }}>Más antiguos
                                primero
                            </option>
                        </select>
                    </th>
                    <th scope="col" style="width: 150px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($empleados->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron resultados.</td>
                    </tr>
                @else
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td>{{ $empleado->id }}</td>
                            <td>{{ $empleado->nombre }} {{ $empleado->apellidos }}</td>
                            <td>{{ $empleado->email }}</td>
                            <td>
                                @if ($empleado->id_rol)
                                    {{ \App\Models\tbl_roles::find($empleado->id_rol)->nombre }}
                                @else
                                    Sin rol asignado
                                @endif
                            </td>
                            <td>{{ $empleado->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    @if ($empleado->id_rol == 3)
                                        <!-- Botón para editar empleado -->
                                        <button class="btn btn-outline-warning btn-sm btn-edit"
                                            data-empleado-id="{{ $empleado->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Formulario para eliminar el usuario -->
                                        <form id="frmEliminar{{ $empleado->id }}"
                                            action="{{ route('empleado.destroy', ['id' => $empleado->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="eliminarUsuario({{ $empleado->id }})"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <!-- Imprimir filas vacías si no se llega al número de registros por página -->
                    @if ($empleados->count() < $empleados->perPage())
                        @for ($i = $empleados->count(); $i < $empleados->perPage(); $i++)
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
                    @for ($i = 1; $i <= $empleados->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $i == $empleados->currentPage() ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <!-- Modal de edición de empleado -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-lg-custom">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">

                        <div class="form-group">
                            <label for="edit_nombre">Nombre:</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control">
                            <div class="error-mensaje" style="color: red;"></div>
                        </div>

                        <div class="form-group">
                            <label for="edit_apellidos">Apellidos:</label>
                            <input type="text" name="apellidos" id="edit_apellidos" class="form-control">
                            <div class="error-mensaje" style="color: red;"></div>
                        </div>

                        <div class="form-group">
                            <label for="edit_email">Email:</label>
                            <input type="email" name="email" id="edit_email" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-outline-dark">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function fetchData(page, perPage, rol, orderDirection, nombre) {
                const url = new URL(window.location.href);
                url.searchParams.set('page', page || 1);
                url.searchParams.set('perPage', perPage || 5);
                url.searchParams.set('rol', rol || '');
                url.searchParams.set('orderDirection', orderDirection || '');
                url.searchParams.set('nombre', nombre || '');

                window.location.href = url.toString();
            }

            $('#filter_rol, #filter_direction, #filter_perPage').change(function() {
                fetchData(
                    $('#pagination_select').val(),
                    $('#filter_perPage').val(),
                    $('#filter_rol').val(),
                    $('#filter_direction').val(),
                    $('#filter_nombre').val()
                );
            });

            $('#pagination_select').change(function() {
                fetchData(
                    $(this).val(),
                    $('#filter_perPage').val(),
                    $('#filter_rol').val(),
                    $('#filter_direction').val(),
                    $('#filter_nombre').val()
                );
            });

            $('#filter_nombre').change(function() {
                fetchData(
                    $('#pagination_select').val(),
                    $('#filter_perPage').val(),
                    $('#filter_rol').val(),
                    $('#filter_direction').val(),
                    $(this).val()
                );
            });

            $(document).on('click', '.btn-edit', function() {
                var empleadoId = $(this).data('empleado-id');
                $.ajax({
                    url: `/empleado/${empleadoId}/edit`,
                    type: 'GET',
                    success: function(response) {
                        $('#edit_id').val(response.id);
                        $('#edit_nombre').val(response.nombre);
                        $('#edit_apellidos').val(response.apellidos);
                        $('#edit_email').val(response.email);
                        $('#editModal').modal('show');
                    }
                });
            });

            $(document).ready(function() {
                $('.btn-edit').click(function(e) {
                    e.preventDefault();
                    var empleadoId = $(this).data('empleado-id');
                    $.ajax({
                        url: '/empleado/' + empleadoId + '/edit',
                        type: 'GET',
                        success: function(response) {
                            // Check if response has the expected fields
                            if (response && response.id) {
                                $('#edit_id').val(response.id);
                                $('#edit_nombre').val(response.nombre);
                                $('#edit_apellidos').val(response.apellidos);
                                $('#edit_email').val(response.email);
                                $('#editForm').attr('action', '/empleado/update/' +
                                    response.id);
                                $('#editModal').modal('show');
                            } else {
                                console.error('Invalid response format:', response);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error details:', status, error, xhr
                                .responseText);
                        }
                    });
                });
            });

        });
    </script>
</body>

</html>
