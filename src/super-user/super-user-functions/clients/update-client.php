<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();
require '../../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    if (!$client) {
        die('Cliente no encontrado.');
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
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="update-client.css">
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <h2>Editar Cliente</h2>
        <form id="registrationForm" action="updateClient.php" method="POST">
            <!-- Añade un input oculto para el ID del cliente -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($client['firstName']); ?>" required>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($client['lastName']); ?>" required>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($client['surname']); ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>

            <label for="phone">Teléfono:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required pattern="[0-9]{10}">

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($client['birthdate']); ?>" required>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino" <?php echo ($client['gender'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?php echo ($client['gender'] == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?php echo ($client['gender'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>

            <button type="submit">Editar</button>
        </form>
    </div>
</body>

</html>
