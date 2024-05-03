<?php
session_start();
require '../../db/connection.php';

$email = $_POST['email'];
$password = $_POST['password']; // La contraseña debe ser verificada contra un hash

$sql = "SELECT id, firstName, lastName, password FROM clients WHERE email = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error de MySQL: ' . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verificar que la contraseña hasheada coincida con la ingresada por el usuario
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];

        // Generar un número de mesa aleatorio, por ejemplo entre 1 y 100
        $table_number = rand(1, 100);

        // Actualizar el número de mesa en la base de datos
        $sqlUpdate = "UPDATE clients SET table_number = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        if ($stmtUpdate === false) {
            die('Error de MySQL: ' . $conn->error);
        }
        $stmtUpdate->bind_param("ii", $table_number, $user['id']);
        $stmtUpdate->execute();

        // Guardar el número de mesa en la sesión para uso posterior
        $_SESSION['table_number'] = $table_number;

        // Redireccionar al usuario a la página donde se muestra el número de mesa
        header("Location: ../client-options/client-options.php");
        exit; // Asegúrate de llamar a exit después de header()
    } else {
        echo "Credenciales inválidas.";
    }
} else {
    echo "Credenciales inválidas.";
}
