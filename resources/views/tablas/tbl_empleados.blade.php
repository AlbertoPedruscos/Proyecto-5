<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tabla de Usuarios</title>
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/8e6d3dccce.js" crossorigin="anonymous"></script>
    {{-- Quicksand --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <!-- Estilos leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- icono -->
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <!-- CSRF -->
    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">Nombre completo</th>
                <th style="width: 20%;">Email</th> <!-- Corregido el carácter ¡ -->
                <th style="width: 10%;">Rol</th>
                <th style="width: 50%;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($empleados as $empleado)
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
                    <td>
                        <!-- Verificar si el ID del empleado es diferente de 2 para mostrar los botones -->
                        @if ($empleado->id != 2)
                            <!-- Botón para editar empleado -->
                            <button class="btn btn-primary btn-sm btn-edit" data-product-id="{{ $empleado->id }}"><i
                                    class="fas fa-edit"></i> Editar</button>
                            <!-- Formulario para eliminar el usuario -->
                            <form id="frmEliminar{{ $empleado->id }}"
                                action="{{ route('empleado.destroy', ['id' => $empleado->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="eliminarUsuario({{ $empleado->id }})"
                                    class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center">No hay resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <!-- Modal de edición de empleado -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('empleado.update', ['id' => $empleado->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_nombre">Nombre:</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit_apellidos">Apellidos:</label>
                            <input type="text" name="apellidos" id="edit_apellidos" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email:</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.btn-edit').click(function(e) {
                e.preventDefault();
                var empleadoId = $(this).data('product-id');
                $.ajax({
                    url: '/empleado/' + empleadoId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        // Llenar el modal de edición con los datos del empleado
                        $('#edit_nombre').val(response.nombre);
                        $('#edit_apellidos').val(response.apellidos);
                        $('#edit_email').val(response.email);
                        // Mostrar el modal de edición
                        $('#editModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Error al cargar los datos del usuario.');
                    }
                });
            });
        });

        function eliminarUsuario(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                position: 'top-end',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('frmEliminar' + id).submit();
                }
            });
        }
    </script>
</body>

</html>
