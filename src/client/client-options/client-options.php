<?php
session_start(); // Asegúrate de iniciar la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú del cliente</title>
    <link rel="stylesheet" href="client-options.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Menú del Cliente</h1>
        <div class="buttons">
            <button id="tableButton">Mesa</button>
            <button id="menuButton">Menú</button>
            <button id="statusButton">Estatus de Preparación</button>
            <button id="commentsButton">Comentarios y Mejoras</button>
        </div>
    </div>
    <script src="client-options.js"></script>
</body>

</html>