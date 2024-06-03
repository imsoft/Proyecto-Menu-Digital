<?php
// Obtén el protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// Obtén el nombre del host (dominio)
$host = $_SERVER['HTTP_HOST'];

// Obtén la ruta completa del script actual
$path = $_SERVER['REQUEST_URI'];

// Concatena todo para obtener la URL completa
$currentUrl = $protocol . "://" . $host . $path;

session_start();
if (
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/companies/read-companies.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/branches/read-branches.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/clients/read-clients.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/tax-data/read-tax-data.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/comments/read-comments.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/employees/read-employees.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/super-user-functions/companies/update-company.php"
) {
    require '../../../db/connection.php';
} else if (
    $currentUrl === "https://menudigital.sbs/src/super-user/create-super-user/create-super-user.php" ||
    $currentUrl === "https://menudigital.sbs/src/super-user/read-super-user/read-super-user.php"

) {
    require '../../db/connection.php';
} else {
    require '../../../db/connection.php';
}

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

// Define la variable base
$base_url = '/src';
?>

<nav class="navbar">
    <a href="/src/super-user/superuser-options/superuser-options.php" class="logo">Menu Digital</a>
    <ul class="menu">
        <li>
            <a href="#about">Negocio</a>
            <ul class="submenu">
                <li><a href="/src/super-user/super-user-functions/companies/read-companies.php">Ver todos los negocios</a></li>
            </ul>
        </li>
        <li>
            <a href="#services">Sucursal</a>
            <ul class="submenu">
                <li><a href="/src/super-user/super-user-functions/branches/read-branches.php">Ver todas las sucursales</a></li>
            </ul>
        </li>
        <li>
            <a href="#services">Clientes</a>
            <ul class="submenu">
                <li><a href="/src/super-user/super-user-functions/clients/read-clients.php">Ver todos los clientes</a></li>
            </ul>
        </li>
        <li>
            <a href="#services">Información Fiscal</a>
            <ul class="submenu">
                <li><a href="/src/super-user/super-user-functions/tax-data/read-tax-data.php">Ver todas las informaciones fiscales</a></li>
            </ul>
        </li>
        <li>
            <a href="#services">Empleados</a>
            <ul class="submenu">
                <li><a href="/src/super-user/super-user-functions/employees/read-employees.php">Ver todos los empleados</a></li>
            </ul>
        </li>
        <li>
            <a href="#services">Comentarios</a>
            <ul class="submenu">
                <li><a href="/src/super-user/super-user-functions/comments/read-comments.php">Ver todos los comentarios</a></li>
            </ul>
        </li>
        <li>
            <a href="#services">Super Usuarios</a>
            <ul class="submenu">
                <li><a href="/src/super-user/create-super-user/create-super-user.php">Agregar super usuario</a></li>
                <li><a href="/src/super-user/read-super-user/read-super-user.php">Ver super usuarios</a></li>
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