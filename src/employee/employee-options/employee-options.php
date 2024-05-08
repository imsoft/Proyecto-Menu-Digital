<?php
session_start();
require '../../db/connection.php';
$employeeId = $_SESSION['user_id'];
$companyId = $_SESSION['user_company'];
$branchId = $_SESSION['user_branch'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="employee-options.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Estado de Preparación de los Alimentos</h1>
        <div class="buttons">
            <button id="viewStatus">Ver Estatus</button>
        </div>
    </div>
    <script src="employee-options.js"></script>
</body>

</html>