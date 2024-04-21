<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Conexión</title>
    <link rel="stylesheet" href="connection.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <?php
        // Configuración de la conexión a la base de datos
        $servername = "localhost"; // Servidor de la base de datos
        $database = "dbaucwkxjvtpaq"; // Nombre de la base de datos
        $username = "unzjj0oggwbf2"; // Nombre de usuario para la conexión
        $password = "unzjj0oggwbf2"; // Contraseña para la conexión

        // Intento de conexión al servidor de base de datos
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Verificación de la conexión
        if (!$conn) {
            echo "<p class='error'>Connection failed: " . mysqli_connect_error() . "</p>"; // Error si la conexión falla
        } else {
            echo "<p class='success'>Connected successfully</p>"; // Mensaje de éxito en la conexión
            mysqli_close($conn); // Cerrar la conexión
        }
        ?>
    </div>
</body>

</html>