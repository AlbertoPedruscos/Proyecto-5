$(document).ready(function() {
    // Función para cargar los datos de la página actual con los filtros aplicados
    function fetchData(page) {
        $.ajax({
            url: window.location.href, // Obtener la URL actual
            method: "GET",
            data: $('#filterForm').serialize() + '&page=' + page, // Serializar los datos del formulario y agregar el número de página
            success: function(data) {
                $('#tabla').html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX: ", error);
            }
        });
    }

    // Manejar el envío del formulario de filtros
    $(document).on('submit', '#filterForm', function(e) {
        e.preventDefault();
        fetchData(1); // Cargar la primera página con los nuevos filtros aplicados
    });

    // Manejar el evento de clic en los enlaces de paginación
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1]; // Obtener el número de página desde el enlace
        fetchData(page); // Cargar la página correspondiente con los filtros aplicados
    });

    // Mostrar el modal de registro al hacer clic en
    $('#abrirModal').click(function() {
        $('#registerModal').modal('show');
    });
});
