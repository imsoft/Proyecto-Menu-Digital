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
    <title>Información de Sucursales</title>
    <link rel="stylesheet" href="read-branch.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="table-container">
        <h2>Detalles de Sucursales</h2>
        <table id="branchTable">
            <thead>
                <tr>
                    <th>Nombre de Sucursal</th>
                    <th>Responsable de Sucursal</th>
                    <th>Domicilio</th>
                    <th>Código Postal</th>
                    <th>Teléfono Celular</th>
                    <th>Sitio Web</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchBranch.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-branch.js"></script>
</body>

</html>