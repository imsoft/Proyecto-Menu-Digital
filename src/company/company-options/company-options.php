<?php
session_start();
require '../../db/connection.php';

// Asegúrate de que el ID de la empresa está disponible en la sesión
if (!isset($_SESSION['company_id'])) {
    die("ID de la empresa no proporcionado.");
}

$companyId = $_SESSION['company_id'];

// Consulta para obtener el nombre del negocio
$sql = "SELECT business_name FROM companies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $company = $result->fetch_assoc();
    $businessName = $company['business_name'];
} else {
    $businessName = "Nombre no encontrado";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="company-options.css">
    <script src="../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../company-menubar/company-menubar.php'; ?>

    <div class="full-screen-image">
        <img src="../../../public/images/splash/splash.png" alt="Main Image" />
    </div>
</body>

</html>