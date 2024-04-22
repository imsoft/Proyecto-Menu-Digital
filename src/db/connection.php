<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Servidor de la base de datos
$database = "dbaucwkxjvtpaq"; // Nombre de la base de datos
$username = "unzjj0oggwbf2"; // Nombre de usuario para la conexión
$password = "unzjj0oggwbf2"; // Contraseña para la conexión

// Intento de conexión al servidor de base de datos
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    error_log("Connection error: " . mysqli_connect_error()); // Log del error
    die("Error connecting to database"); // Terminar el script o manejar el error adecuadamente
}

// Verificación de la conexión
// if (!$conn) {
//     echo mysqli_connect_error(); // Error si la conexión falla
// } else {
//     echo "Connected successfully"; // Mensaje de éxito en la conexión
//     mysqli_close($conn); // Cerrar la conexión
// }
