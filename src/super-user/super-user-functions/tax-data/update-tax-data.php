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
    <link rel="stylesheet" href="../../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Información Fiscal</h2>
        <form id="updateForm" action="updateTaxData.php" method="POST">
            <!-- Añade un input oculto para el ID de la información fiscal -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($taxData['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($taxData['firstName']); ?>" required placeholder="Ingrese el nombre completo">
            <div class="form-note">Ingrese el nombre del titular de la cuenta fiscal.</div>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($taxData['lastName']); ?>" required placeholder="Ingrese el apellido paterno">
            <div class="form-note">Ingrese el primer apellido del titular.</div>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($taxData['surname']); ?>" required placeholder="Ingrese el apellido materno">
            <div class="form-note">Ingrese el segundo apellido del titular.</div>

            <label for="rfc">RFC:</label>
            <input type="text" id="rfc" name="rfc" value="<?php echo htmlspecialchars($taxData['rfc']); ?>" required placeholder="ABCD123456XYZ" pattern="^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$" maxlength="13">
            <div class="form-note">El RFC debe tener 13 caracteres: 4 letras, 6 dígitos y 3 alfanuméricos.</div>

            <label for="socialName">Razón Social:</label>
            <input type="text" id="socialName" name="socialName" value="<?php echo htmlspecialchars($taxData['socialName']); ?>" required placeholder="Ingrese la razón social">
            <div class="form-note">Nombre oficial de la empresa registrado legalmente.</div>

            <label for="tradeName">Nombre Comercial:</label>
            <input type="text" id="tradeName" name="tradeName" value="<?php echo htmlspecialchars($taxData['tradeName']); ?>" required placeholder="Ingrese el nombre comercial">
            <div class="form-note">Nombre público con el que opera la empresa.</div>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($taxData['address']); ?>" required placeholder="Calle, número, colonia, ciudad">
            <div class="form-note">Dirección completa incluyendo calle, número, colonia y ciudad.</div>

            <label for="curp">CURP:</label>
            <input type="text" id="curp" name="curp" value="<?php echo htmlspecialchars($taxData['curp']); ?>" required placeholder="ABCD123456HMXYZ01" pattern="^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z0-9]{2}$" maxlength="18">
            <div class="form-note">El CURP debe tener 18 caracteres: 4 letras, 6 dígitos, H/M, 5 letras, 2 alfanuméricos.</div>

            <label for="company_id">ID de la Empresa:</label>
            <input type="number" id="company_id" name="company_id" value="<?php echo htmlspecialchars($taxData['company_id']); ?>" required placeholder="Ingrese el ID de la empresa">
            <div class="form-note">ID único asignado a la empresa.</div>

            <button type="submit">Editar</button>
        </form>
    </div>
</body>

</html>