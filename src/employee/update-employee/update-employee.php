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
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="form-container">
        <h2>Editar Empleado</h2>
        <form id="registrationForm" action="updateEmployee.php" method="POST">
            <!-- Añade un input oculto para el ID del empleado -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($employee['id']); ?>">

            <label for="firstName">Nombre:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($employee['firstName']); ?>" required>

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($employee['lastName']); ?>" required>

            <label for="surname">Apellido Materno:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($employee['surname']); ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>

            <label for="phone">Teléfono Celular:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required pattern="[0-9]{10}">

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($employee['birthdate']); ?>" required>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="masculino" <?php echo ($employee['gender'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?php echo ($employee['gender'] == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?php echo ($employee['gender'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Verificar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Editar</button>
        </form>
    </div>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/;

            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                event.preventDefault();
            }

            if (!passwordRegex.test(password)) {
                alert('La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.');
                event.preventDefault();
            }
        });
    </script>
</body>

</html>