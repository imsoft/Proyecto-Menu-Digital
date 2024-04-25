<?php
session_start();
require '../db/connection.php';

$email = $_POST['email'];
$password = $_POST['password']; // La contraseña debe ser verificada contra un hash

$sql = "SELECT id, firstName, lastName FROM users WHERE email = ? AND password = ?";  // Asumiendo que el password está hasheado y es verificado correctamente
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['firstName'];
    $_SESSION['lastName'] = $user['lastName'];
    header("Location: ../client-options/client-options.html"); // Redirige al dashboard o página inicial
} else {
    echo "Credenciales inválidas.";
}
$conn->close();
