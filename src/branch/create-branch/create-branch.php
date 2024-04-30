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
    <title>Sucursal</title>
    <link rel="stylesheet" href="create-branch.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="form-container">
        <h2>Registro de Sucursal</h2>
        <form id="registrationForm" action="createBranch.php" method="POST">
            <input type="hidden" id="companyId" name="companyId" value="<?php echo htmlspecialchars($companyId); ?>">

            <label for="branchName">Nombre de Sucursal:</label>
            <input type="text" id="branchName" name="branchName" required>

            <label for="branchManager">Responsable de Sucursal:</label>
            <input type="text" id="branchManager" name="branchManager" required>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" required>

            <label for="postalCode">Código Postal:</label>
            <input type="text" id="postalCode" name="postalCode" required pattern="[0-9]{5}">

            <label for="cellphone">Teléfono Celular:</label>
            <input type="tel" id="cellphone" name="cellphone" required pattern="[0-9]{10}">

            <label for="website">Sitio Web:</label>
            <input type="url" id="website" name="website">

            <button type="submit">Registrar</button>
        </form>
    </div>
    <!-- <script src="create-branch.js"></script> -->
</body>

</html>