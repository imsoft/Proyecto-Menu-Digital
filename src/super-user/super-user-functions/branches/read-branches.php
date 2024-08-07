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
    <title>Lista de Sucursales</title>
    <link rel="stylesheet" href="read-branches.css">
    <link rel="stylesheet" href="../../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="table-container">
        <!-- Flecha de regreso -->
      <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Datos de las Sucursales</h2>
        <table id="branchTable">
            <thead>
                <tr>
                    <th>Nombre de la Sucursal</th>
                    <th>Encargado</th>
                    <th>Dirección</th>
                    <th>Código Postal</th>
                    <th>Teléfono</th>
                    <th>Sitio Web</th>
                    <th>ID de la Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchBranches.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-branches.js"></script>
</body>

</html>