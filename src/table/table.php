<?php
session_start(); // Asegúrate de iniciar la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa</title>
    <link rel="stylesheet" href="table.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h2>Número de Folio de la Mesa</h2>
        <div class="folio-number">
            <p>Folio: <span id="folio">
                    <?php
                    echo isset($_SESSION['table_number']) ? htmlspecialchars($_SESSION['table_number']) : 'No asignado';
                    ?>
                </span></p>
        </div>
    </div>
    <script src="table.js"></script>
</body>

</html>