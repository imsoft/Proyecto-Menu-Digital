<?php
session_start();
require '../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

$email = $_POST['email'];
$password = $_POST['password']; // La contraseña debe ser verificada contra un hash

$sql = "SELECT id, username, password FROM superusers WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Error de MySQL: ' . $conn->error);
}

$stmt->bind_param("s", $email);

if (!$stmt->execute()) {
    die('Error ejecutando la consulta: ' . $stmt->error);
}
$result = $stmt->get_result();
if (!$result) {
    die('Error obteniendo los resultados: ' . $conn->error);
}

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['superuser_id'] = $user['id'];
        $_SESSION['superuser_name'] = $user['username'];
        header("Location: ../super-user-options/super-user-options.php"); // Redirige al dashboard o página inicial
        exit;
    } else {
        echo "Credenciales inválidas.";
    }
} else {
    echo "Credenciales inválidas.";
}
$conn->close();
