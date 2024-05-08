<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="client-menu.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>

    <body>
        <div class="container">
            <h1>Menú del Restaurante</h1>
            <div class="menu-buttons">
                <button onclick="filterMenu('comida')">Comida</button>
                <button onclick="filterMenu('bebida')">Bebida</button>
                <button onclick="filterMenu('extras')">Extras</button>
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
</body>

</html>