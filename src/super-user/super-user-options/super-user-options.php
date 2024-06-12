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
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../super-user-menubar/super-user-menubar.css">
</head>

<body>
    <?php include '../super-user-menubar/super-user-menubar.php'; ?>
    <div class="full-screen-image">
        <img src="../../../public/images/splash/splash.png" alt="Main Image" />
    </div>
    <script src="../super-user-menubar/super-user-menubar.js"></script>
</body>

</html>