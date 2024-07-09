<?php
session_start();
require '../../db/connection.php';  // Ajusta la ruta según sea necesario.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['captcha'])) {
        die('Todos los campos son requeridos.');
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    if ($captcha != $_SESSION['captcha']) {
        die('Captcha incorrecto.');
    }

    $sql = "SELECT id, business_name, user_type, password FROM companies WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['company_id'] = $user['id'];
                $_SESSION['user_name'] = $user['business_name'];
                $_SESSION['user_type'] = $user['user_type'];

                header("Location: ../company-options/company-options.php"); // Ajusta el URL según sea necesario
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
