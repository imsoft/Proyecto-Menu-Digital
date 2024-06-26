<?php
session_start(); // Asegúrate de que la sesión esté iniciada

if (!isset($_SESSION['company_id'])) {
    // Redirigir al usuario para iniciar sesión si no hay un company_id en la sesión
    header("Location: ../../company/company-login/company-login.html");
    exit;
}

$companyId = $_SESSION['company_id']; // Recupera el company_id de la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Fiscales</title>
    <link rel="stylesheet" href="create-tax-data.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <h2>Registro de Datos Fiscales</h2>
        <form id="registrationForm" action="createTaxData.php" method="POST">

            <input type="hidden" id="companyId" name="companyId" value="<?php echo htmlspecialchars($companyId); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" required>

            <label for="rfc">RFC:</label>
            <input type="text" id="rfc" name="rfc" required pattern="^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$">

            <label for="socialName">Nombre o Razón Social:</label>
            <input type="text" id="socialName" name="socialName" required>

            <label for="tradeName">Nombre de Comercio:</label>
            <input type="text" id="tradeName" name="tradeName" required>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" required>

            <label for="curp">CURP:</label>
            <input type="text" id="curp" name="curp" required pattern="^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z0-9]{2}$">

            <button type="submit">Registrar</button>
        </form>
    </div>
    <!-- <script src="create-tax-data.js"></script> -->
</body>

</html>