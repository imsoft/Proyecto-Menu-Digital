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
        <h2>Editar Cliente</h2>
        <form id="registrationForm" action="updateClient.php" method="POST">
            <!-- Añade un input oculto para el ID del cliente -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($client['firstName']); ?>" required placeholder="Ingrese el nombre del cliente">
            <div class="form-note">Ingrese el nombre completo del cliente.</div>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($client['lastName']); ?>" required placeholder="Ingrese el apellido paterno">
            <div class="form-note">Ingrese el primer apellido del cliente.</div>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($client['surname']); ?>" required placeholder="Ingrese el apellido materno">
            <div class="form-note">Ingrese el segundo apellido del cliente.</div>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required placeholder="Ingrese el correo electrónico">
            <div class="form-note">Ingrese un correo electrónico válido.</div>

            <label for="phone">Teléfono:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required placeholder="555-123-4567 o 01-555-123-4567" pattern="(?:01-)?\d{3}-\d{3}-\d{4}">
            <div class="form-note">Formato requerido: 555-123-4567 o 01-555-123-4567. Use guiones para separar los bloques de números.</div>
            <div class="error" id="phoneError"></div>

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($client['birthdate']); ?>" required>
            <div class="form-note">Seleccione la fecha de nacimiento del cliente.</div>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino" <?php echo ($client['gender'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?php echo ($client['gender'] == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?php echo ($client['gender'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
            <div class="form-note">Seleccione el género del cliente.</div>

            <button type="submit">Editar</button>
        </form>
    </div>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            // Validación del teléfono
            const phone = document.getElementById("phone").value;
            const phonePattern = /^(?:01-)?\d{3}-\d{3}-\d{4}$/;
            const phoneError = document.getElementById("phoneError");
            phoneError.textContent = "";

            if (!phonePattern.test(phone)) {
                phoneError.textContent = "El número de teléfono no cumple con el formato requerido.";
                event.preventDefault();
                return false;
            }

            // Validación de la fecha de nacimiento
            const birthdateInput = document.getElementById("birthdate");
            const birthdate = new Date(birthdateInput.value);
            const today = new Date();

            // Calcular la diferencia de años
            const age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();

            // Verificar si la fecha de nacimiento es hoy o en el futuro
            if (birthdate >= today) {
                alert("La fecha de nacimiento no puede ser el día actual o una fecha futura.");
                event.preventDefault();
                return false;
            }

            // Verificar si la edad es menor de 18 años
            if (age < 18 || (age === 18 && monthDiff < 0) || (age === 18 && monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                alert("El cliente debe tener al menos 18 años.");
                event.preventDefault();
                return false;
            }

            // Verificar si el año es antes de 1900
            if (birthdate.getFullYear() < 1900) {
                alert("No se aceptan fechas de años muy lejanos en el pasado.");
                event.preventDefault();
                return false;
            }

            return true;
        });
    </script>
</body>

</html>
