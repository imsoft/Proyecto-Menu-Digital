<?php
session_start();
require '../../db/connection.php'; // Asegúrate de que la ruta es correcta
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Superusuario</title>
    <link rel="stylesheet" href="create-super-user.css">
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
        <h2>Registro de Superusuario</h2>
        <form id="registrationForm" action="createSuperuser.php" method="POST" onsubmit="return validateForm()">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required placeholder="Ingrese un nombre de usuario">
            <div class="form-note">El nombre de usuario debe ser único y fácil de recordar.</div>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="Ingrese su correo electrónico">
            <div class="form-note">Ingrese un correo electrónico válido para recibir notificaciones.</div>

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
