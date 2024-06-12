<?php
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos
session_start(); // Asegúrate de que la sesión esté iniciada
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <link rel="stylesheet" href="client-menu.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../client/client-menubar/client-menubar.css">
    <script src="../../client/client-menubar/client-menubar.js"></script>
</head>

<body>
    <?php include '../../client/client-menubar/client-menubar.php'; ?>
    <div class="container">
        <h1>Menú del Restaurante</h1>
        <div class="menu-buttons">
            <button onclick="filterMenu('comida')">Comida</button>
            <button onclick="filterMenu('bebida')">Bebida</button>
            <button onclick="filterMenu('extras')">Extras</button>
            <button onclick="filterMenu('postre')">Postre</button>
        </div>
        <div id="menuItems" class="menu-items">
            <?php include 'fetchClientMenu.php'; ?>
        </div>
        <div class="management-buttons">
            <button onclick="window.location.href='../../cart/viewCart/viewCart.php'">Ver Carrito</button>
        </div>
    </div>
    <script src="client-menu.js"></script>
</body>

</html>
