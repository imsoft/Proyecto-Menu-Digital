<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    if (!$employee) {
        die('Empleado no encontrado.');
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
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="update-employee.css">
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
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Empleado</h2>
        <form id="registrationForm" action="updateEmployee.php" method="POST" onsubmit="return validateForm()">
            <!-- Añade un input oculto para el ID del empleado -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($employee['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($employee['firstName']); ?>" required placeholder="Ingrese el nombre del empleado">
            <div class="form-note">Ingrese el nombre completo del empleado.</div>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($employee['lastName']); ?>" required placeholder="Ingrese el apellido paterno">
            <div class="form-note">Ingrese el primer apellido del empleado.</div>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($employee['surname']); ?>" required placeholder="Ingrese el apellido materno">
            <div class="form-note">Ingrese el segundo apellido del empleado.</div>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required placeholder="Ingrese el correo electrónico">
            <div class="form-note">Ingrese un correo electrónico válido.</div>

            <label for="phone">Teléfono Celular:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required pattern="(?:01-)?\d{3}-\d{3}-\d{4}|\d{10}" placeholder="555-123-4567 o 01-555-123-4567">
            <div class="form-note">Debe tener 10 caracteres numéricos (ej. 555-123-4567 o 01-555-123-4567).</div>
            <div class="error" id="phoneError"></div>

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($employee['birthdate']); ?>" required>
            <div class="form-note">Seleccione la fecha de nacimiento del empleado. Debe ser mayor de 18 años y no puede ser una fecha lejana en el pasado.</div>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino" <?php echo ($employee['gender'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?php echo ($employee['gender'] == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?php echo ($employee['gender'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
            <div class="form-note">Seleccione el género del empleado.</div>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="Cree una contraseña segura">
            <span class="toggle-password" onclick="togglePasswordVisibility('password')">Mostrar</span>
            <div class="password-requirements">
                La contraseña debe tener entre 12 y 16 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial (@$!%*?&).
            </div>
            <div class="error" id="passwordError"></div>

            <label for="confirmPassword">Verificar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Repita la contraseña">
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

        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const phoneError = document.getElementById('phoneError');

            passwordError.textContent = '';
            confirmPasswordError.textContent = '';
            phoneError.textContent = '';

            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/;
            const phoneRegex = /^(?:01-)?\d{3}-\d{3}-\d{4}$|^\d{10}$/;

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Las contraseñas no coinciden.';
                event.preventDefault();
                return false;
            }

            if (!passwordRegex.test(password)) {
                passwordError.textContent = 'La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.';
                event.preventDefault();
                return false;
            }

            // Validación del teléfono
            const phone = document.getElementById('phone').value;
            if (!phoneRegex.test(phone)) {
                phoneError.textContent = 'El número de teléfono debe tener 10 caracteres numéricos en formato 555-123-4567 o 01-555-123-4567.';
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
                alert("El empleado debe tener al menos 18 años.");
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
