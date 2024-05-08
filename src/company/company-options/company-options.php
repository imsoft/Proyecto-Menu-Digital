<?php
session_start();
require '../../db/connection.php';
$companyId = $_SESSION['company_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="company-options.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Negocio</h1>
        <div class="buttons">
            <button id="viewCompany">Ver información del negocio</button>
        </div>
        <h2>Sucursal</h2>
        <div class="buttons">
            <button id="addBranch">Agregar Sucursal</button>
            <button id="viewBranch">Ver Sucursales</button>
        </div>
        <h2>Menú y Productos</h2>
        <div class="buttons">
            <button id="loadProductMenu">Agregar productos al menú</button>
            <button id="viewMenu">Ver menú</button>
        </div>
        <h2>Información Fiscal</h2>
        <div class="buttons">
            <button id="addFiscalInfo">Agregar Información Fiscal</button>
            <button id="viewFiscalInfo">Ver Información Fiscal</button>
        </div>
        <h2>Empleados</h2>
        <div class="buttons">
            <button id="addEmployee">Agregar Empleados</button>
            <button id="viewEpleoyee">Ver Empleados</button>
        </div>
        <h2>Otros</h2>
        <div class="buttons">
            <button id="consumptionHistory">Historial de consumo</button>
            <button id="customerFeedback">Comentarios y Sugerencias de los Clientes</button>
            <button id="viewGraph">Ver gráficos</button>
        </div>
    </div>
    <script src="company-options.js"></script>
</body>

</html>