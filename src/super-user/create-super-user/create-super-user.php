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
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../super-user-menubar/super-user-menubar.css">
    <script src="../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <h2>Registro de Superusuario</h2>
        <form id="registrationForm" action="createSuperuser.php" method="POST" onsubmit="return validateForm()">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

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