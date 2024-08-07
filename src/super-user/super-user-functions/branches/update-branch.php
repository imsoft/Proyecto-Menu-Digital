<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();
require '../../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM branches WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $branch = $result->fetch_assoc();
    if (!$branch) {
        die('Sucursal no encontrada.');
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
    <title>Editar Sucursal</title>
    <link rel="stylesheet" href="update-branch.css">
    <link rel="stylesheet" href="../../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
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
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
      <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Sucursal</h2>
        <form id="registrationForm" action="updateBranch.php" method="POST" onsubmit="return validateForm()">
            <!-- Añade un input oculto para el ID de la sucursal -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($branch['id']); ?>">

            <label for="branch_name">Nombre de la Sucursal:</label>
            <input type="text" id="branch_name" name="branch_name" value="<?php echo htmlspecialchars($branch['branch_name']); ?>" required placeholder="Ingrese el nombre de la sucursal">
            <div class="form-note">Ingrese el nombre oficial de la sucursal.</div>

            <label for="branch_manager">Encargado:</label>
            <input type="text" id="branch_manager" name="branch_manager" value="<?php echo htmlspecialchars($branch['branch_manager']); ?>" required placeholder="Ingrese el nombre del encargado">
            <div class="form-note">Ingrese el nombre completo del encargado de la sucursal.</div>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($branch['address']); ?>" required placeholder="Calle, número, colonia, ciudad">
            <div class="form-note">Dirección completa, incluyendo calle, número, colonia y ciudad.</div>

            <label for="postal_code">Código Postal:</label>
            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($branch['postal_code']); ?>" required pattern="[0-9]{5}" placeholder="12345">
            <div class="form-note">Debe tener 5 caracteres numéricos (ej. 12345).</div>

            <label for="cellphone">Teléfono:</label>
            <input type="tel" id="cellphone" name="cellphone" value="<?php echo htmlspecialchars($branch['cellphone']); ?>" required pattern="(?:01-)?\d{3}-\d{3}-\d{4}" placeholder="555-123-4567 o 01-555-123-4567">
            <div class="form-note">Formato requerido: 555-123-4567 o 01-555-123-4567. Use guiones para separar los bloques de números.</div>
            <div class="error" id="phoneError"></div>

            <label for="website">Sitio Web:</label>
            <input type="url" id="website" name="website" value="<?php echo htmlspecialchars($branch['website']); ?>" required placeholder="https://www.ejemplo.com">
            <div class="form-note">Ingrese la URL completa del sitio web.</div>

            <label for="company_id">ID de la Empresa:</label>
            <input type="text" id="company_id" name="company_id" value="<?php echo htmlspecialchars($branch['company_id']); ?>" required placeholder="Ingrese el ID de la empresa">
            <div class="form-note">Ingrese el ID de la empresa a la que pertenece la sucursal.</div>

            <button type="submit">Editar</button>
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
