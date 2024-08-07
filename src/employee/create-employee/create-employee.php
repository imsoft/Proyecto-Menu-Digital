<?php
session_start();

require '../../db/connection.php'; // Asegúrate de que la ruta es correcta

// Asumiendo que `company_id` se guarda en la sesión al iniciar sesión
$companyId = $_SESSION['company_id'];

// Obtener la empresa según el company_id de la sesión
$companyQuery = "SELECT id, business_name FROM companies WHERE id = ?";
$companyStmt = $conn->prepare($companyQuery);
$companyStmt->bind_param("i", $companyId);
$companyStmt->execute();
$companyResult = $companyStmt->get_result();

// Obtener las sucursales de esta empresa
$branchesQuery = "SELECT id, branch_name FROM branches WHERE company_id = ?";
$branchesStmt = $conn->prepare($branchesQuery);
$branchesStmt->bind_param("i", $companyId);
$branchesStmt->execute();
$branchesResult = $branchesStmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleado</title>
    <link rel="stylesheet" href="create-employee.css">
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
        <h2>Registro de Empleado</h2>
        <form id="registrationForm" action="createEmployee.php" method="POST" onsubmit="return validateForm()">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" required placeholder="Ingrese el nombre del empleado">
            <div class="form-note">Ingrese el nombre completo del empleado.</div>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Ingrese el apellido paterno">
            <div class="form-note">Ingrese el primer apellido del empleado.</div>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" required placeholder="Ingrese el apellido materno">
            <div class="form-note">Ingrese el segundo apellido del empleado.</div>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="Ingrese el correo electrónico">
            <div class="form-note">Ingrese un correo electrónico válido.</div>

            <label for="phone">Teléfono Celular:</label>
            <input type="tel" id="phone" name="phone" required pattern="(?:\+?52)?(?:\d{10}|\d{3}-\d{3}-\d{4})" placeholder="555-123-4567 o +525551234567">
            <div class="form-note">Ingrese el teléfono en formato 555-123-4567 o +525551234567. Puede incluir lada y guiones.</div>
            <div class="error" id="phoneError"></div>

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" required>
            <div class="form-note">Seleccione la fecha de nacimiento del empleado. Debe ser mayor de 18 años y no puede ser una fecha lejana en el pasado.</div>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="otro">Otro</option>
            </select>
            <div class="form-note">Seleccione el género del empleado.</div>

            <!-- Selector de Empresa (no es necesario si siempre es el mismo) -->
            <label for="company">Empresa:</label>
            <select id="company" name="company_id" required>
                <option value="">Seleccione una empresa...</option>
                <?php if ($company = $companyResult->fetch_assoc()) : ?>
                    <option value="<?= $company['id'] ?>" selected><?= htmlspecialchars($company['business_name']) ?></option>
                <?php endif; ?>
            </select>
            <div class="form-note">La empresa está preseleccionada.</div>

            <!-- Selector de Sucursal -->
            <label for="branch">Sucursal:</label>
            <select id="branch" name="branch_id">
                <option value="">No Aplicable</option>
                <?php while ($branch = $branchesResult->fetch_assoc()) : ?>
                    <option value="<?= $branch['id'] ?>"><?= htmlspecialchars($branch['branch_name']) ?></option>
                <?php endwhile; ?>
            </select>
            <div class="form-note">Seleccione la sucursal donde trabajará el empleado, si aplica.</div>

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

            <button type="submit">Registrar</button>
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

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Las contraseñas no coinciden.';
                return false;
            }

            if (!passwordRegex.test(password)) {
                passwordError.textContent = 'La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.';
                return false;
            }

            // Validación del teléfono
            const phone = document.getElementById('phone').value;
            if (!phoneRegex.test(phone)) {
                phoneError.textContent = 'El número de teléfono debe tener 10 caracteres numéricos en formato 555-123-4567 o +525551234567.';
                return false;
            }

            // Validación de la fecha de nacimiento
            const birthdateInput = document.getElementById("birthdate");
            const birthdate = new Date(birthdateInput.value);
            const today = new Date();

            // Verificar si la fecha de nacimiento es hoy o en el futuro
            if (birthdate >= today) {
                alert("La fecha de nacimiento no puede ser el día actual o una fecha futura.");
                return false;
            }

            // Calcular la diferencia de años
            const age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();

            // Verificar si la edad es menor de 18 años
            if (age < 18 || (age === 18 && monthDiff < 0) || (age === 18 && monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                alert("El empleado debe tener al menos 18 años.");
                return false;
            }

            // Verificar si el año es antes de 1900
            if (birthdate.getFullYear() < 1900) {
                alert("No se aceptan fechas de años muy lejanos en el pasado.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
