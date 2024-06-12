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
require '../../db/connection.php';

// Asegúrate de que el ID del cliente está disponible en la sesión
if (!isset($_SESSION['user_id'])) {
    die("ID del cliente no proporcionado.");
}

$clientId = $_SESSION['user_id'];

// Consulta para obtener el nombre del cliente
$sql = "SELECT e.firstName, c.business_name, b.branch_name 
        FROM employees e
        LEFT JOIN companies c ON e.company_id = c.id
        LEFT JOIN branches b ON e.branch_id = b.id
        WHERE e.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
    $clientName = $client['firstName'];
    $businessName = $client['business_name'];
    $branchName = $client['branch_name'];
} else {
    $clientName = "Cliente no encontrado";
    $businessName = "";
    $branchName = "";
}

$stmt->close();
$conn->close();

// Define la variable base
$base_url = '/src';
?>

<nav class="navbar">
    <a href="/src/employee/employee-options/employee-options.php" class="logo">Menu Digital</a>
    <div class="menu-container">
        <ul class="menu">
            <li>
                <a href="#about">Estatus</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/branch/food-preparation/food-preparation.php">Ver Estatus de pedidos</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/logout/logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
    <div class="client-name">
        <?php echo htmlspecialchars($clientName); ?>
        <?php if (!empty($businessName)) { ?>
            - <?php echo htmlspecialchars($businessName); ?>
        <?php } ?>
        <?php if (!empty($branchName)) { ?>
            - <?php echo htmlspecialchars($branchName); ?>
        <?php } ?>
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
</nav>