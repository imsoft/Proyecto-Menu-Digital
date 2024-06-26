<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();
require '../../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM tax_data WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $taxData = $result->fetch_assoc();
    if (!$taxData) {
        die('Información fiscal no encontrada.');
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
    <title>Editar Información Fiscal</title>
    <link rel="stylesheet" href="update-tax-data.css">
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <h2>Editar Información Fiscal</h2>
        <form id="updateForm" action="updateTaxData.php" method="POST">
            <!-- Añade un input oculto para el ID de la información fiscal -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($taxData['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($taxData['firstName']); ?>" required>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($taxData['lastName']); ?>" required>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($taxData['surname']); ?>" required>

            <label for="rfc">RFC:</label>
            <input type="text" id="rfc" name="rfc" value="<?php echo htmlspecialchars($taxData['rfc']); ?>" required>

            <label for="socialName">Razón Social:</label>
            <input type="text" id="socialName" name="socialName" value="<?php echo htmlspecialchars($taxData['socialName']); ?>" required>

            <label for="tradeName">Nombre Comercial:</label>
            <input type="text" id="tradeName" name="tradeName" value="<?php echo htmlspecialchars($taxData['tradeName']); ?>" required>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($taxData['address']); ?>" required>

            <label for="curp">CURP:</label>
            <input type="text" id="curp" name="curp" value="<?php echo htmlspecialchars($taxData['curp']); ?>" required>

            <label for="company_id">ID de la Empresa:</label>
            <input type="number" id="company_id" name="company_id" value="<?php echo htmlspecialchars($taxData['company_id']); ?>" required>

            <button type="submit">Editar</button>
        </form>
    </div>
</body>

</html>
