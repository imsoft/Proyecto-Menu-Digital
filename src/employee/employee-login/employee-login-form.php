<?php
session_start();

// Generar dos números aleatorios para el captcha
$numero1 = rand(1, 10);
$numero2 = rand(1, 10);
$_SESSION['captcha_num1'] = $numero1;
$_SESSION['captcha_num2'] = $numero2;
$_SESSION['captcha'] = $numero1 + $numero2;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="employee-login.css" />
  <link rel="stylesheet" href="../../arrow/arrow.css" />
  <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
  <div class="login-container">
    <!-- Flecha de regreso -->
    <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
    <h2>Iniciar Sesión</h2>
    <form id="loginForm" action="employee-login.php" method="POST">
    <div class="form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required placeholder="Ingrese su correo electrónico" />
        <div class="form-note">Ingrese un correo electrónico válido.</div>
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña" />
        <div class="form-note">La contraseña debe tener al menos 8 caracteres.</div>
      </div>
      <div class="form-group">
        <label for="captcha">¿Cuánto es <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?>?:</label>
        <input type="text" id="captcha" name="captcha" required placeholder="Ingrese el resultado" />
        <div class="form-note">Ingrese la suma de los dos números para verificar que no eres un robot.</div>
      </div>
      <button type="submit">Entrar</button>
    </form>
  </div>
</body>

</html>