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
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
    <style>
        .toggle-password {
            cursor: pointer;
            user-select: none;
            margin-left: 5px;
        }

        .form-note {
            font-size: 0.9em;
            color: #666;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <!-- Flecha de regreso -->
    <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
    <div class="form-container">
        <h2>Registro de Sucursal</h2>
        <form id="registrationForm" action="createBranch.php" method="POST" onsubmit="return validateForm()">
            <input type="hidden" id="companyId" name="companyId" value="<?php echo htmlspecialchars($companyId); ?>">

            <label for="branchName">Nombre de Sucursal:</label>
            <input type="text" id="branchName" name="branchName" required placeholder="Ingrese el nombre de la sucursal">
            <div class="form-note">Ingrese el nombre oficial de la sucursal.</div>

            <label for="branchManager">Responsable de Sucursal:</label>
            <input type="text" id="branchManager" name="branchManager" required placeholder="Nombre del responsable">
            <div class="form-note">Nombre completo de la persona a cargo.</div>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" required placeholder="Ingrese la dirección completa">
            <div class="form-note">Incluya calle, número, colonia y ciudad.</div>

            <label for="postalCode">Código Postal:</label>
            <input type="text" id="postalCode" name="postalCode" required placeholder="12345" pattern="[0-9]{5}" maxlength="5">
            <div class="form-note">Debe tener 5 caracteres numéricos (por ejemplo, 12345).</div>

            <label for="cellphone">Teléfono Celular:</label>
            <input type="tel" id="cellphone" name="cellphone" required placeholder="555-123-4567 o 01-555-123-4567" pattern="(?:01-)?\d{3}-\d{3}-\d{4}">
            <div class="form-note">Formato requerido: 555-123-4567 o 01-555-123-4567. Use guiones para separar los bloques de números.</div>
            <div class="error" id="phoneError"></div>

            <label for="website">Sitio Web:</label>
            <input type="url" id="website" name="website" placeholder="https://ejemplo.com">
            <div class="form-note">URL completa del sitio web de la sucursal (opcional).</div>

            <button type="submit">Registrar</button>
        </form>
    </div>

    <script>
        function validateForm() {
            // Validación del teléfono
            const phone = document.getElementById("cellphone").value;
            const phonePattern = /^(?:01-)?\d{3}-\d{3}-\d{4}$/;
            const phoneError = document.getElementById("phoneError");
            phoneError.textContent = "";

            if (!phonePattern.test(phone)) {
                phoneError.textContent = "El número de teléfono no cumple con el formato requerido.";
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
