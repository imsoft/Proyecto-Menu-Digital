<?php
session_start();
require '../../db/connection.php';

// Asegúrate de que el ID del superusuario está disponible en la sesión
if (!isset($_SESSION['superuser_id'])) {
    die("ID del superusuario no proporcionado.");
}

$superuserId = $_SESSION['superuser_id'];

// Consulta para obtener el nombre del superusuario
$sql = "SELECT username FROM superusers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $superuserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $superuser = $result->fetch_assoc();
    $username = $superuser['username'];
} else {
    $username = "Nombre no encontrado";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Superusuario</title>
    <link rel="stylesheet" href="super-user-options.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <nav class="navbar">
        <a href="../superuser-options/superuser-options.php" class="logo">Menu Digital</a>
        <ul class="menu">
            <li>
                <a href="#about">Negocio</a>
                <ul class="submenu">
                    <li><a href="../super-user-functions/companies/read-companies.php">Ver todos los negocios</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Sucursal</a>
                <ul class="submenu">
                    <li><a href="../super-user-functions/branches/read-branches.php">Ver todas las sucursales</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Clientes</a>
                <ul class="submenu">
                    <li><a href="../super-user-functions/clients/read-clients.php">Ver todos los clientes</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Información Fiscal</a>
                <ul class="submenu">
                    <li><a href="../super-user-functions/tax-data/read-tax-data.php">Ver todas las informaciones fiscales</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Empleados</a>
                <ul class="submenu">
                    <li><a href="../super-user-functions/employees/read-employees.php">Ver todos los empleados</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Comentarios</a>
                <ul class="submenu">
                    <li><a href="../super-user-functions/comments/read-comments.php">Ver todos los comentarios</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Super Usuarios</a>
                <ul class="submenu">
                    <li><a href="../create-super-user/create-super-user.php">Agregar super usuario</a></li>
                    <li><a href="../read-super-user/read-super-user.php">Ver super usuarios</a></li>
                </ul>
            </li>
        </ul>
        <div class="business-name">
            <?php echo htmlspecialchars($username); ?>
        </div>
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