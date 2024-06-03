<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../../db/connection.php';
session_start(); // Asegúrate de iniciar la sesión al principio del script

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Comentarios</title>
    <link rel="stylesheet" href="read-comments.css">
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="table-container">
        <h2>Datos de los Comentarios</h2>
        <table id="commentTable">
            <thead>
                <tr>
                    <th>ID del Cliente</th>
                    <th>ID de la Sucursal</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                    <th>Fecha de Creación</th>
                    <th>ID de la Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchComments.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-comments.js"></script>
</body>

</html>