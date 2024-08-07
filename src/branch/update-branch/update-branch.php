<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sucursal</title>
    <link rel="stylesheet" href="update-branch.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
    <style>
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
        <h2>Editar Sucursal</h2>
        <form id="registrationForm" action="updateBranch.php" method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($branch['id']); ?>">

            <label for="branchName">Nombre de Sucursal:</label>
            <input type="text" id="branchName" name="branchName" value="<?php echo htmlspecialchars($branch['branch_name']); ?>" required placeholder="Ingrese el nombre de la sucursal">
            <div class="form-note">Ingrese el nombre oficial de la sucursal.</div>

            <label for="branchManager">Responsable de Sucursal:</label>
            <input type="text" id="branchManager" name="branchManager" value="<?php echo htmlspecialchars($branch['branch_manager']); ?>" required placeholder="Nombre del responsable">
            <div class="form-note">Nombre completo de la persona a cargo.</div>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($branch['address']); ?>" required placeholder="Ingrese la dirección completa">
            <div class="form-note">Incluya calle, número, colonia y ciudad.</div>

            <label for="postalCode">Código Postal:</label>
            <input type="text" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($branch['postal_code']); ?>" required placeholder="12345" pattern="[0-9]{5}" maxlength="5">
            <div class="form-note">Debe tener 5 caracteres numéricos (por ejemplo, 12345).</div>

            <label for="cellphone">Teléfono Celular:</label>
            <input type="tel" id="cellphone" name="cellphone" value="<?php echo htmlspecialchars($branch['cellphone']); ?>" required placeholder="555-123-4567 o +52-555-123-4567">
            <div class="form-note">Debe ser de 10 dígitos, y puede incluir lada y guiones (ej. 555-123-4567 o +52-555-123-4567).</div>
            <div class="error" id="cellphoneError"></div>

            <label for="website">Sitio Web:</label>
            <input type="url" id="website" name="website" value="<?php echo htmlspecialchars($branch['website']); ?>" placeholder="https://ejemplo.com">
            <div class="form-note">URL completa del sitio web de la sucursal (opcional).</div>

            <button type="submit">Editar</button>
        </form>
    </div>
    <!-- <script src="update-branch.js"></script> -->
    <script>
        function validateForm() {
            const cellphone = document.getElementById('cellphone').value;
            const cellphoneError = document.getElementById('cellphoneError');
            const cellphoneRegex = /^(?:\+?52[- ]?)?(?:\d{10}|\d{3}[- ]\d{3}[- ]\d{4})$/;

            cellphoneError.textContent = '';

            if (!cellphoneRegex.test(cellphone)) {
                cellphoneError.textContent = "El número de teléfono debe tener 10 caracteres numéricos, y puede incluir lada y guiones (ej. 555-123-4567 o +52-555-123-4567).";
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
