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
  <link rel="stylesheet" href="client-login.css" />
  <link rel="stylesheet" href="../../arrow/arrow.css" />
  <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
  <div class="login-container">
    <!-- Flecha de regreso -->
    <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
    <h2>Iniciar Sesión</h2>
    <form id="loginForm" action="client-login.php" method="POST">
    <div class="form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required />
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required />
      </div>
      <div class="form-group">
        <label for="captcha">¿Cuánto es <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?>?:</label>
        <input type="text" id="captcha" name="captcha" placeholder="Resultado" required />
      </div>
      <button type="submit">Entrar</button>
      <p class="register-link">
        ¿No tienes cuenta?
        <a href="../create-client/create-client.html">Regístrate</a>
      </p>
    </form>
  </div>
</body>

</html>