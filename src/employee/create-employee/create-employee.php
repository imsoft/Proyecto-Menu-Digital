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
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <h2>Registro de Empleado</h2>
        <form id="registrationForm" action="createEmployee.php" method="POST" onsubmit="return validateForm()">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Teléfono Celular:</label>
            <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}">

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" required>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="otro">Otro</option>
            </select>

            <!-- Selector de Empresa (no es necesario si siempre es el mismo) -->
            <label for="company">Empresa:</label>
            <select id="company" name="company_id" required>
                <option value="">Seleccione una empresa...</option>
                <?php if ($company = $companyResult->fetch_assoc()) : ?>
                    <option value="<?= $company['id'] ?>"><?= htmlspecialchars($company['business_name']) ?></option>
                <?php endif; ?>
            </select>

            <!-- Selector de Sucursal -->
            <label for="branch">Sucursal:</label>
            <select id="branch" name="branch_id">
                <option value="">No Aplicable</option>
                <?php while ($branch = $branchesResult->fetch_assoc()) : ?>
                    <option value="<?= $branch['id'] ?>"><?= htmlspecialchars($branch['branch_name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Verificar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Registrar</button>
        </form>
    </div>
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/;

            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                return false;
            }

            if (!passwordRegex.test(password)) {
                alert('La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.');
                return false;
            }

            return true;
        }
    </script>
</body>

</html>