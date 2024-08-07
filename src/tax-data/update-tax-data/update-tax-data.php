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
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Datos Fiscales</h2>
        <form id="registrationForm" action="updateTaxData.php" method="POST">
            <!-- Añade un input oculto para el ID de los datos fiscales -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($taxData['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($taxData['firstName']); ?>" required placeholder="Ingrese su nombre">
            <div class="form-note">Nombre completo del titular.</div>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($taxData['lastName']); ?>" required placeholder="Ingrese su apellido paterno">
            <div class="form-note">Ingrese su apellido paterno.</div>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($taxData['surname']); ?>" required placeholder="Ingrese su apellido materno">
            <div class="form-note">Ingrese su apellido materno.</div>

            <label for="rfc">RFC:</label>
            <input type="text" id="rfc" name="rfc" value="<?php echo htmlspecialchars($taxData['rfc']); ?>" required placeholder="ABCD123456XYZ" pattern="^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$" maxlength="13">
            <div class="form-note">Formato RFC: 4 letras, 6 dígitos, 3 caracteres alfanuméricos (ej. ABCD123456XYZ).</div>

            <label for="socialName">Nombre o Razón Social:</label>
            <input type="text" id="socialName" name="socialName" value="<?php echo htmlspecialchars($taxData['socialName']); ?>" required placeholder="Nombre o razón social">
            <div class="form-note">Nombre oficial o razón social de la empresa.</div>

            <label for="tradeName">Nombre de Comercio:</label>
            <input type="text" id="tradeName" name="tradeName" value="<?php echo htmlspecialchars($taxData['tradeName']); ?>" required placeholder="Nombre del comercio">
            <div class="form-note">Nombre del comercio o nombre público.</div>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($taxData['address']); ?>" required placeholder="Calle, número, colonia, ciudad">
            <div class="form-note">Incluya calle, número, colonia, ciudad y estado.</div>

            <label for="curp">CURP:</label>
            <input type="text" id="curp" name="curp" value="<?php echo htmlspecialchars($taxData['curp']); ?>" required placeholder="ABCD123456HMXYZ01" pattern="^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z0-9]{2}$" maxlength="18">
            <div class="form-note">Formato CURP: 4 letras, 6 dígitos, H/M, 5 letras, 2 caracteres alfanuméricos (ej. ABCD123456HMXYZ01).</div>

            <button type="submit">Editar</button>
        </form>
    </div>
    <!-- <script src="update-tax-data.js"></script> -->
</body>

</html>