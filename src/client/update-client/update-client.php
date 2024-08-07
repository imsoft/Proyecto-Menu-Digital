<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';

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

// Validación de fecha de nacimiento (PHP)
$birthdate = new DateTime($client['birthdate']);
$today = new DateTime();
$minBirthdate = $today->modify('-18 years');

if ($birthdate > $minBirthdate) {
    die('El cliente debe tener al menos 18 años.');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="update-client.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
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

        .password-requirements {
            font-size: 0.8em;
            color: #888;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Cliente</h2>
        <form id="registrationForm" action="updateClient.php" method="POST" onsubmit="return validateForm()">
            <!-- Añade un input oculto para el ID del cliente -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($client['firstName']); ?>" required placeholder="Ingrese el nombre">

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($client['lastName']); ?>" required placeholder="Ingrese el apellido paterno">

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($client['surname']); ?>" required placeholder="Ingrese el apellido materno">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required placeholder="Ingrese el correo electrónico">
            <div class="form-note">Ingrese un correo electrónico válido.</div>

            <label for="phone">Teléfono Celular:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required pattern="(?:\+?52)?(?:\d{10}|\d{3}-\d{3}-\d{4})" placeholder="555-123-4567 o +525551234567">
            <div class="form-note">Ingrese el teléfono en formato 555-123-4567 o +525551234567. Puede incluir lada y guiones.</div>
            <div class="error" id="phoneError"></div>

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($client['birthdate']); ?>" required>
            <div class="form-note">Debe ser una fecha válida y mayor de 18 años.</div>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino" <?php echo ($client['gender'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?php echo ($client['gender'] == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?php echo ($client['gender'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($client['password']); ?>" required placeholder="12-16 caracteres con mayúsculas, minúsculas, números y especiales">
            <span class="toggle-password" onclick="togglePasswordVisibility('password')">Mostrar</span>
            <div class="password-requirements">
                La contraseña debe tener entre 12 y 16 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial (@$!%*?&).
            </div>
            <div class="error" id="passwordError"></div>

            <label for="confirmPassword">Verificar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Repite la contraseña">
            <span class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')">Mostrar</span>
            <div class="error" id="confirmPasswordError"></div>

            <button type="submit">Editar</button>
        </form>
    </div>
    <script>
        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const phoneError = document.getElementById('phoneError');

            passwordError.textContent = '';
            confirmPasswordError.textContent = '';
            phoneError.textContent = '';

            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/;
            const phoneRegex = /^(?:\+?52)?(?:\d{10}|\d{3}-\d{3}-\d{4})$/;

            if (!passwordRegex.test(password)) {
                passwordError.textContent = 'La contraseña no cumple con los requisitos.';
                return false;
            }

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Las contraseñas no coinciden.';
                return false;
            }

            // Validación del teléfono
            const phone = document.getElementById('phone').value;
            if (!phoneRegex.test(phone)) {
                phoneError.textContent = 'El número de teléfono debe tener 10 caracteres numéricos en formato 555-123-4567 o +525551234567.';
                return false;
            }

            // Validación de fecha de nacimiento
            const birthdateInput = document.getElementById('birthdate').value;
            const birthdate = new Date(birthdateInput);
            const today = new Date();
            const minBirthdate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

            if (birthdate >= today) {
                alert('La fecha de nacimiento no puede ser hoy o en el futuro.');
                return false;
            }

            if (birthdate > minBirthdate) {
                alert('El cliente debe ser mayor de 18 años.');
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
