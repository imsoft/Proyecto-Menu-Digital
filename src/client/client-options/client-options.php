<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start(); // Asegúrate de iniciar la sesión al principio del script
$companyId = $_SESSION['company_id']; // Obtener el company_id de la sesión
$clientId = $_SESSION['user_id']; // Obtener el user_id de la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="client-options.css">
    <link rel="stylesheet" href="../client-menubar/client-menubar.css">
    <script src="../client-menubar/client-menubar.js"></script>
</head>

<body>
    <?php include '../client-menubar/client-menubar.php'; ?>

    <div class="full-screen-image">
        <img src="../../../public/images/splash/splash.png" alt="Main Image" />
    </div>
</body>

</html>