<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM companies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $company = $result->fetch_assoc();
    if (!$company) {
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
    <title>Editar Negocio</title>
    <link rel="stylesheet" href="update-company.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../company-menubar/company-menubar.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <script src="../company-menubar/company-menubar.js"></script>
    <style>
        .required-field {
            color: red;
        }

        .form-note {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <?php include '../company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Negocio</h2>
        <form id="businessForm" action="updateCompany.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="companyId" value="<?php echo htmlspecialchars($company['id']); ?>">
            <input type="hidden" name="currentLogoPath" value="<?php echo htmlspecialchars($company['logo_path']); ?>">

            <label for="logo">Logo del Negocio:</label>
            <input type="file" id="logo" name="logo" accept="image/*">
            <img src="<?php echo htmlspecialchars($company['logo_path']); ?>" alt="Logo Actual">
            <div class="form-note">Seleccione una nueva imagen si desea cambiar la actual.</div>

            <label for="associatedName">Nombre Asociado:<span class="required-field">*</span></label>
            <input type="text" id="associatedName" name="associatedName" value="<?php echo htmlspecialchars($company['associated_name']); ?>" required placeholder="Ingrese el nombre asociado">
            <div class="form-note">Ingrese el nombre asociado a la empresa.</div>

            <label for="businessName">Nombre del Negocio:<span class="required-field">*</span></label>
            <input type="text" id="businessName" name="businessName" value="<?php echo htmlspecialchars($company['business_name']); ?>" required placeholder="Ingrese el nombre del negocio">
            <div class="form-note">Ingrese el nombre oficial del negocio.</div>

            <label for="address">Domicilio:<span class="required-field">*</span></label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($company['address']); ?>" required placeholder="Ingrese la dirección del negocio">
            <div class="form-note">Proporcione la dirección completa del negocio.</div>

            <label for="email">Correo Electrónico:<span class="required-field">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($company['email']); ?>" required placeholder="Ingrese el correo electrónico">
            <div class="form-note">Ingrese un correo electrónico válido.</div>

            <label for="cellphone">Celular:<span class="required-field">*</span></label>
            <input type="tel" id="cellphone" name="cellphone" value="<?php echo htmlspecialchars($company['cellphone']); ?>" required pattern="[0-9]{10}" placeholder="5551234567">
            <div class="form-note">Debe tener 10 caracteres numéricos (ej. 5551234567).</div>

            <label for="foodType">Tipo de Establecimiento de Alimentos:<span class="required-field">*</span></label>
            <select id="foodType" name="foodType" required>
                <option value="restaurante" <?php echo $company['food_type'] == 'restaurante' ? 'selected' : ''; ?>>Restaurante</option>
                <option value="cafe" <?php echo $company['food_type'] == 'cafe' ? 'selected' : ''; ?>>Café</option>
                <option value="panaderia" <?php echo $company['food_type'] == 'panaderia' ? 'selected' : ''; ?>>Panadería</option>
                <option value="otro" <?php echo $company['food_type'] == 'otro' ? 'selected' : ''; ?>>Otro</option>
            </select>
            <div class="form-note">Seleccione el tipo de establecimiento.</div>

            <fieldset>
                <legend>¿Cuentas con RFC?<span class="required-field">*</span></legend>
                <label><input type="radio" name="hasRFC" value="yes" <?php echo $company['has_rfc'] ? 'checked' : ''; ?> required> Sí</label>
                <label><input type="radio" name="hasRFC" value="no" <?php echo !$company['has_rfc'] ? 'checked' : ''; ?>> No</label>
            </fieldset>

            <fieldset>
                <legend>¿El menú y el precio aplican a todas las sucursales?<span class="required-field">*</span></legend>
                <label><input type="radio" name="consistentMenu" value="yes" <?php echo $company['consistent_menu'] ? 'checked' : ''; ?> required> Sí</label>
                <label><input type="radio" name="consistentMenu" value="no" <?php echo !$company['consistent_menu'] ? 'checked' : ''; ?>> No</label>
            </fieldset>

            <button type="submit">Editar</button>
            <div class="form-note">
                Los campos marcados con <span class="required-field">*</span> son obligatorios.
            </div>
        </form>
    </div>
    <!-- <script src="update-company.js"></script> -->
</body>

</html>
