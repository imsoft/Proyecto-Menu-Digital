<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../../db/connection.php';
session_start(); // Asegúrate de que la sesión esté iniciada

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de negocios</title>
    <link rel="stylesheet" href="read-companies.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="table-container">
        <h2>Datos de los Negocios</h2>
        <table id="companyTable">
            <thead>
                <tr>
                    <th>Logo del Negocio</th>
                    <th>Nombre Asociado</th>
                    <th>Nombre del Negocio</th>
                    <th>Domicilio</th>
                    <th>Correo Electrónico</th>
                    <th>Celular</th>
                    <th>Tipo de Establecimiento de Alimentos</th>
                    <th>¿Cuentas con RFC?</th>
                    <th>¿El menú y el precio aplican a todas las sucursales?</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se mostrarán aquí -->
                <?php include 'fetchCompanies.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-companies.js"></script>
</body>

</html>
