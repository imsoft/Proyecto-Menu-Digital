<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start(); // Asegúrate de iniciar la sesión al principio del script
$companyId = $_SESSION['company_id']; // Obtener el company_id de la sesión
$branchId = $_SESSION['branch_id'] ?? null; // Obtener el branch_id de la sesión si existe

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de empleados</title>
    <link rel="stylesheet" href="read-employee.css">
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
        <h2>Datos de los Empleados</h2>
        <table id="employeeTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono Celular</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Género</th>
                    <th>Empresa</th>
                    <th>Sucursal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchEmployees.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-employee.js"></script>
</body>

</html>