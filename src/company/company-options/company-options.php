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
    <nav class="navbar">
        <a href="../company-options/company-options.php" class="logo">Menu Digital</a>
        <ul class="menu">
            <li>
                <a href="#about">Negocio</a>
                <ul class="submenu">
                    <li><a href="../read-company/read-company.php">Ver información del negocio</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Sucursal</a>
                <ul class="submenu">
                    <li><a href="../../branch/create-branch/create-branch.php">Agregar Sucursal</a></li>
                    <li><a href="../../branch/read-branch/read-branch.php">Ver Sucursales</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Menú y Productos</a>
                <ul class="submenu">
                    <li><a href="../../menu/create-menu/create-menu.php">Agregar productos al menú</a></li>
                    <li><a href="../../menu/read-menu/read-menu.php">Ver menú</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Información Fiscal</a>
                <ul class="submenu">
                    <li><a href="../../tax-data/create-tax-data/create-tax-data.php">Agregar Información Fiscal</a></li>
                    <li><a href="../../tax-data/read-tax-data/read-tax-data.php">Ver Información Fiscal</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Empleados</a>
                <ul class="submenu">
                    <li><a href="../../employee/create-employee/create-employee.php">Agregar Empleados</a></li>
                    <li><a href="../../employee/read-employee/read-employee.php">Ver Empleados</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Otros</a>
                <ul class="submenu">
                    <li><a href="../../company/company-record/company-record.php">Historial de consumo</a></li>
                    <li><a href="../company-comments/read-company-comments/read-company-comments.php">Comentarios y Sugerencias de los Clientes</a></li>
                    <li><a href="../../company/company-graph/company-graph.php">Ver gráficos</a></li>
                </ul>
            </li>
        </ul>
        <div class="menu-toggle">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>

    <div class="full-screen-image">
        <img src="../../../public/images/splash/splash.png" alt="Main Image" />
    </div>

    <script>
        const menuToggle = document.querySelector(".menu-toggle");
        const navbar = document.querySelector(".navbar");

        menuToggle.addEventListener("click", () => {
            navbar.classList.toggle("active");
        });
    </script>
</body>

</html>