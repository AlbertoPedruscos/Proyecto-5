<?php
use App\Models\modeloPlazas;
$plazas = modeloPlazas::all();
use Illuminate\Support\Facades\DB;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="./css/aparca.css">
    {{-- FUENTE --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="modal" id="modal">
        <div class="modal-content">
            <input type="hidden" id="estado">
            <div class="form-group">
                <label for="id_plaza">Plaza:</label>
                <select id="id_plaza" name="id_plaza" disabled>
                    <option value="">Selecciona una plaza</option>
                    <?php foreach ($plazas as $plaza): ?>
                    <option value="<?php echo $plaza->id; ?>"><?php echo $plaza->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nom_cliente">Codigo:</label>
                <input type="text" id="nom_cliente" name="nom_cliente">
            </div>
            <div class="form-group">
                <label for="firma">Firma:</label>
                <canvas id="canvas"></canvas>
            </div>
            <div class="form-group">
                <button type="button" onclick="validar()">Reservar</button>
                <button onclick="limpiarCanvas()" style="background-color: orange" type="button">Limpiar</button>
                <button onclick="cerrar()" style="background-color: red" type="button">Cerrar</button>
            </div>
            <br>
            <br>
        </div>
    </div>
    <div id="container">
        <br>
        <a href="/volverA"><button style="background-color: red">Volver</button></a>
        <br>
        <div>
            <div id="item">
                <h1>Parkin de Vladivostok</h1>
                <br>
                <h2>Planta: 1</h2>
            </div>
            <div id="gridContainer"></div>
        </div>
    </div>
</body>

</html>
<script src="./js/aparca.js"></script>
