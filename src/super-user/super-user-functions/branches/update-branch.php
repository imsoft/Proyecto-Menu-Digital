<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

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
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="form-container">
        <h2>Editar Sucursal</h2>
        <form id="registrationForm" action="updateBranch.php" method="POST">
            <!-- Añade un input oculto para el ID de la sucursal -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($branch['id']); ?>">

            <label for="branch_name">Nombre de la Sucursal:</label>
            <input type="text" id="branch_name" name="branch_name" value="<?php echo htmlspecialchars($branch['branch_name']); ?>" required>

            <label for="branch_manager">Encargado:</label>
            <input type="text" id="branch_manager" name="branch_manager" value="<?php echo htmlspecialchars($branch['branch_manager']); ?>" required>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($branch['address']); ?>" required>

            <label for="postal_code">Código Postal:</label>
            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($branch['postal_code']); ?>" required pattern="[0-9]{5}">

            <label for="cellphone">Teléfono:</label>
            <input type="tel" id="cellphone" name="cellphone" value="<?php echo htmlspecialchars($branch['cellphone']); ?>" required pattern="[0-9]{10}">

            <label for="website">Sitio Web:</label>
            <input type="text" id="website" name="website" value="<?php echo htmlspecialchars($branch['website']); ?>" required>

            <label for="company_id">ID de la Empresa:</label>
            <input type="text" id="company_id" name="company_id" value="<?php echo htmlspecialchars($branch['company_id']); ?>" required>

            <button type="submit">Editar</button>
        </form>
    </div>
</body>

</html>