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
    <title>Lista de Información Fiscal</title>
    <link rel="stylesheet" href="read-tax-data.css">
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="table-container">
        <h2>Datos de la Información Fiscal</h2>
        <table id="taxDataTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>RFC</th>
                    <th>Razón Social</th>
                    <th>Nombre Comercial</th>
                    <th>Dirección</th>
                    <th>CURP</th>
                    <th>ID de la Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchTaxData.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-tax-data.js"></script>
</body>

</html>
