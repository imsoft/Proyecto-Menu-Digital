<?php
require "../db/connection.php";
session_start(); // Asegúrate de iniciar la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa</title>
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../client/client-menubar/client-menubar.css">
    <script src="../client/client-menubar/client-menubar.js"></script>
</head>

<body>
    <?php include '../client/client-menubar/client-menubar.php'; ?>
    <div class="container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Número de Folio de la Mesa</h2>
        <div class="folio-number">
            <p>Folio: <span id="folio">
                    <?php
                    echo isset($_SESSION['table_number']) ? htmlspecialchars($_SESSION['table_number']) : 'No asignado';
                    ?>
                </span></p>
        </div>
    </div>
</body>

</html>