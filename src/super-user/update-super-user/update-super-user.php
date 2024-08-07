<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();
require '../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM superusers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $superuser = $result->fetch_assoc();
    if (!$superuser) {
        die('Superusuario no encontrado.');
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
    <title>Editar Superusuario</title>
    <link rel="stylesheet" href="update-super-user.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../super-user-menubar/super-user-menubar.css">
    <script src="../super-user-menubar/super-user-menubar.js"></script>
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
    <?php include '../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Editar Superusuario</h2>
        <form id="registrationForm" action="updateSuperuser.php" method="POST" onsubmit="return validateForm()">
            <!-- Añade un input oculto para el ID del superusuario -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($superuser['id']); ?>">

            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($superuser['username']); ?>" required placeholder="Ingrese el nombre de usuario">
            <div class="form-note">Debe contener entre 5 y 20 caracteres.</div>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($superuser['email']); ?>" required placeholder="ejemplo@correo.com">
            <div class="form-note">Por favor, ingrese un correo electrónico válido.</div>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="Ingrese una nueva contraseña">
            <span class="toggle-password" onclick="togglePasswordVisibility('password')">Mostrar</span>
            <div class="form-note password-requirements">Debe tener entre 12 y 16 caracteres, e incluir mayúsculas, minúsculas, números y caracteres especiales.</div>
            <div class="error" id="passwordError"></div>

            <label for="confirmPassword">Verificar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Reingrese la contraseña">
            <span class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')">Mostrar</span>
            <div class="form-note">Vuelva a ingresar la contraseña para confirmar.</div>
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
            // Validación de la contraseña
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            passwordError.textContent = '';
            confirmPasswordError.textContent = '';

            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/;

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Las contraseñas no coinciden.';
                return false;
            }

            if (!passwordRegex.test(password)) {
                passwordError.textContent = 'La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.';
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
