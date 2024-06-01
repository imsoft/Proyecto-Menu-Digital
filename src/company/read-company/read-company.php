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
    <title>Lista de negocios</title>
    <link rel="stylesheet" href="read-company.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../company-menubar/company-menubar.css">
    <script src="../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../company-menubar/company-menubar.php'; ?>
    <div class="table-container">
        <h2>Datos del Negocio</h2>
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
                <?php include 'fetch-company.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-company.js"></script>
</body>

</html>