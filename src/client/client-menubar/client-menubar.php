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

if ($currentUrl === "https://menudigital.sbs/src/table/table.php") {
    require '../db/connection.php';
} else {
    require '../../db/connection.php';
}


// Asegúrate de que el ID del cliente está disponible en la sesión
if (!isset($_SESSION['user_id'])) {
    die("ID del cliente no proporcionado.");
}

$clientId = $_SESSION['user_id'];

// Consulta para obtener el nombre del cliente
$sql = "SELECT firstName, lastName FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
    $clientName = $client['firstName'] . ' ' . $client['lastName'];
} else {
    $clientName = "Cliente no encontrado";
}

$stmt->close();
$conn->close();

// Define la variable base
$base_url = '/src';
?>

<nav class="navbar">
    <a href="../client-options/client-options.php" class="logo">Menu Digital</a>
    <div class="menu-container">
        <ul class="menu">
            <li>
                <a href="#about">Mesa</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/table/table.php">Ver número de mesa</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Menú</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/client/select-business-branch/select-business-branch.php">Ver Menú</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Estatus de preparación</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/client/preparation-status/preparation-status.php">Ver estatus de preparación</a></li>
                </ul>
            </li>
            <li>
                <a href="#services">Comentarios y mejoras</a>
                <ul class="submenu">
                    <li><a href="<?php echo $base_url; ?>/comment/create-comment/create-comment.php">Ver comentarios y mejoras</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/logout/logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
    <div class="client-name">
        <?php echo htmlspecialchars($clientName); ?>
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
</nav>