<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
    <title>CRUD php Vanilla</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Cliente</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody id="resultado"></tbody>
    </table>
</body>

<script src="<?php echo e(asset('/js/script.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
<?php /**PATH C:\xampp\htdocs\www\MyControlPark\resources\views/empleado/reservas.blade.php ENDPATH**/ ?>