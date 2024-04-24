<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM tax_data WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $taxData = $result->fetch_assoc();
    if (!$taxData) {
        die('Datos fiscales no encontrados.');
    }
} else {
    die('ID no proporcionado.');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Datos Fiscales</title>
    <link rel="stylesheet" href="update-tax-data.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="form-container">
        <h2>Editar Datos Fiscales</h2>
        <form id="registrationForm" action="updateTaxData.php" method="POST">
            <!-- Añade un input oculto para el ID de los datos fiscales -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($taxData['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($taxData['firstName']); ?>" required>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($taxData['lastName']); ?>" required>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($taxData['surname']); ?>" required>

            <label for="rfc">RFC:</label>
            <input type="text" id="rfc" name="rfc" value="<?php echo htmlspecialchars($taxData['rfc']); ?>" required pattern="^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$">

            <label for="socialName">Nombre o Razón Social:</label>
            <input type="text" id="socialName" name="socialName" value="<?php echo htmlspecialchars($taxData['socialName']); ?>" required>

            <label for="tradeName">Nombre de Comercio:</label>
            <input type="text" id="tradeName" name="tradeName" value="<?php echo htmlspecialchars($taxData['tradeName']); ?>" required>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($taxData['address']); ?>" required>

            <label for="curp">CURP:</label>
            <input type="text" id="curp" name="curp" value="<?php echo htmlspecialchars($taxData['curp']); ?>" required pattern="^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z0-9]{2}$">

            <button type="submit">Editar</button>
        </form>
    </div>
    <!-- <script src="update-tax-data.js"></script> -->
</body>

</html>