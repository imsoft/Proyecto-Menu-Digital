<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start(); // Asegúrate de iniciar la sesión al principio del script
$clientId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de Clientes</title>
    <link rel="stylesheet" href="read-comment.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="table-container">
        <h2>Comentarios de Clientes</h2>
        <table id="clientTable">
            <thead>
                <tr>
                    <th>Calificación</th>
                    <th>Comentario</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchComments.php'; ?>
            </tbody>

        </table>
    </div>
    <script src="read-comment.js"></script>
</body>

</html>