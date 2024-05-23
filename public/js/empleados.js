$(document).ready(function() {
    function fetchData(page) {
        $.ajax({
            url: "?page=" + page,
            method: "GET",
            data: $('#filterForm').serialize(),
            success: function(data) {
                $('#tabla').html(data);
                updateFormValues();
            }
        });
    }

    function updateFormValues() {
        $('#search').val('{{ $search }}');
        $('#rol').val('{{ $rol }}');
        $('#perPage').val('{{ $perPage }}');
    }

    $('#perPage, #search, #rol').on('change', function() {
        $('#filterForm').submit();
    });

    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        fetchData(1);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetchData(page);
    });

    $('#abrirModal').click(function() {
        $('#registerModal').modal('show');
    });

    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var empleadoId = $(this).data('product-id');
        $.ajax({
            url: '/empleado/' + empleadoId + '/edit',
            type: 'GET',
            success: function(response) {
                $('#edit_nombre').val(response.nombre);
                $('#edit_apellidos').val(response.apellidos);
                $('#edit_email').val(response.email);
                $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error al cargar los datos del usuario.');
            }
        });
    });
});
