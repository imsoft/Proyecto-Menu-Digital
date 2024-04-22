<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="read-menu.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="table-container">
        <h2>Catálogo de Productos</h2>
        <table id="productTable">
            <thead>
                <tr>
                    <th>Imagen del Producto</th>
                    <th>Nombre del Producto</th>
                    <th>Descripción</th>
                    <th>Nombre de la Categoría</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchMenu.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-menu.js"></script>
</body>

</html>