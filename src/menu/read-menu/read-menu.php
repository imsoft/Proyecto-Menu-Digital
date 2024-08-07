<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start(); // Asegúrate de que la sesión esté iniciada

if (!isset($_SESSION['company_id'])) {
    // Redirigir al usuario para iniciar sesión si no hay un company_id en la sesión
    header("Location: ../../company/company-login/company-login.html");
    exit;
}

$companyId = $_SESSION['company_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="read-menu.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <div class="table-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
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