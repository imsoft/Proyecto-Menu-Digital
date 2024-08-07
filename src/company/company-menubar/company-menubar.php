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
    $currentUrl === "https://menudigital.sbs/src/company/company-comments/read-company-comments/read-company-comments.php" ||
    $currentUrl === "https://menudigital.sbs/src/company/company-ingredients/create-company-ingredients/create-company-ingredients.php" ||
    $currentUrl === "https://menudigital.sbs/src/company/company-ingredients/read-company-ingredients/read-company-ingredients.php"
) {
    require '../../../db/connection.php';
} else {
    require '../../db/connection.php';
}

// Asegúrate de que el ID de la empresa está disponible en la sesión
if (!isset($_SESSION['company_id'])) {
    die("ID de la empresa no proporcionado.");
}

$companyId = $_SESSION['company_id'];

// Consulta para obtener el nombre del negocio y el logo
$sql = "SELECT business_name, logo_url FROM companies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $company = $result->fetch_assoc();
    $businessName = $company['business_name'];
    $logoUrl = $company['logo_url']; // Ruta al logo
} else {
    $businessName = "Nombre no encontrado";
    $logoUrl = "/path/to/default-logo.png"; // Ruta a un logo por defecto si no se encuentra
}

$stmt->close();
$conn->close();

// Define la variable base
$base_url = '/src';
?>

<nav class="navbar">
    <!-- Logo de la empresa -->
    <a href="/src/company/company-options/company-options.php" class="logo">
        <img src="<?php echo htmlspecialchars($logoUrl); ?>" alt="<?php echo htmlspecialchars($businessName); ?>" class="company-logo">
    </a>
    <a href="/src/company/company-options/company-options.php" class="logo">Menu Digital</a>
    <div class="menu-container">
        <ul class="menu">
            <li>
                <a href="#about">Negocio</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/company/read-company/read-company.php">Ver información del negocio</a></li>
                    <li><a href="<?php echo $base_url; ?>/company/company-food-preparation/company-food-preparation.php">Pedidos actuales</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Sucursal</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/branch/create-branch/create-branch.php">Agregar Sucursal</a></li>
                    <li><a href="<?php echo $base_url; ?>/branch/read-branch/read-branch.php">Ver Sucursales</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Menú y Productos</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/menu/create-menu/create-menu.php">Agregar productos al menú</a></li>
                    <li><a href="<?php echo $base_url; ?>/menu/read-menu/read-menu.php">Ver menú</a></li>
                    <li><a href="<?php echo $base_url; ?>/company/company-ingredients/create-company-ingredients/create-company-ingredients.php">Agregar ingredientes</a></li>
                    <li><a href="<?php echo $base_url; ?>/company/company-ingredients/read-company-ingredients/read-company-ingredients.php">Ver ingredientes</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Información Fiscal</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/tax-data/create-tax-data/create-tax-data.php">Agregar Información Fiscal</a></li>
                    <li><a href="<?php echo $base_url; ?>/tax-data/read-tax-data/read-tax-data.php">Ver Información Fiscal</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Empleados</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/employee/create-employee/create-employee.php">Agregar Empleados</a></li>
                    <li><a href="<?php echo $base_url; ?>/employee/read-employee/read-employee.php">Ver Empleados</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Otros</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/company/company-record/company-record.php">Historial de consumo</a></li>
                    <li><a href="<?php echo $base_url; ?>/company/company-comments/read-company-comments/read-company-comments.php">Comentarios y Sugerencias de los Clientes</a></li>
                    <li><a href="<?php echo $base_url; ?>/company/company-graph/company-graph.php">Ver gráficos</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/logout/logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
    <div class="business-name">
        <?php echo htmlspecialchars($businessName); ?>
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Nota de campos obligatorios -->
    <div class="form-note">
        Nota: Los campos marcados con <span class="required-field">*</span> son obligatorios en formularios.
    </div>

    <script src="company-menubar.js"></script>
</nav>
