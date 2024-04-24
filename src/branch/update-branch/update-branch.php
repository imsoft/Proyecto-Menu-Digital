<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';

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
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($branch['id']); ?>">

            <label for="branchName">Nombre de Sucursal:</label>
            <input type="text" id="branchName" name="branchName" value="<?php echo htmlspecialchars($branch['branch_name']); ?>" required>

            <label for="branchManager">Responsable de Sucursal:</label>
            <input type="text" id="branchManager" name="branchManager" value="<?php echo htmlspecialchars($branch['branch_manager']); ?>" required>

            <label for="address">Domicilio:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($branch['address']); ?>" required>

            <label for="postalCode">Código Postal:</label>
            <input type="text" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($branch['postal_code']); ?>" required>

            <label for="cellphone">Teléfono Celular:</label>
            <input type="tel" id="cellphone" name="cellphone" value="<?php echo htmlspecialchars($branch['cellphone']); ?>" required pattern="[0-9]{10}">

            <label for="website">Sitio Web:</label>
            <input type="url" id="website" name="website" value="<?php echo htmlspecialchars($branch['website']); ?>">

            <button type="submit">Editar</button>
        </form>
    </div>
    <!-- <script src="update-branch.js"></script> -->
</body>

</html>
