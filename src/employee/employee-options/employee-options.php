<?php
session_start();
require '../../db/connection.php';

$employeeId = $_SESSION['user_id'] ?? null;
$companyId = $_SESSION['user_company'] ?? null;
$branchId = $_SESSION['user_branch'] ?? null;

if (!$employeeId || !$companyId) {
    echo "No se encontró la información del empleado o de la empresa.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="employee-options.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="employee-options.css">
    <link rel="stylesheet" href="../employee-menubar/employee-menubar.css">
    <script src="../employee-menubar/employee-menubar.js"></script>
</head>

<body>
    <?php include '../employee-menubar/employee-menubar.php'; ?>
    <div class="container">
        <h1>Estado de Preparación de los Alimentos</h1>
        <div class="buttons">
            <button id="viewStatus">Ver Estatus</button>
        </div>
    </div>
    <script src="employee-options.js"></script>
</body>

</html>