<?php
session_start();
require '../../db/connection.php';  // Ajusta la ruta según sea necesario.

// Chequear si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para buscar el usuario con el correo dado
    $sql = "SELECT id, business_name, user_type, password FROM companies WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Verificar que la contraseña hasheada coincida con la ingresada por el usuario
            if (password_verify($password, $user['password'])) {
                // Establecer variables de sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['business_name'];
                $_SESSION['user_type'] = $user['user_type'];

                // Redireccionar al usuario a la página de inicio de su perfil o dashboard
                header("Location: ../employee-options/employee-options.html"); // Ajusta el URL según sea necesario
                exit;
            } else {
                $error_message = "Credenciales inválidas.";
            }
        } else {
            $error_message = "Credenciales inválidas.";
        }
        $stmt->close();
    } else {
        $error_message = "Error de conexión: " . $conn->error;
    }
    $conn->close();
}
