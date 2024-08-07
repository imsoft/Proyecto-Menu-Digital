<?php
session_start();
require '../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password']; // La contraseña debe ser verificada contra un hash
    $captcha = $_POST['captcha'];

    if ($captcha != $_SESSION['captcha']) {
        die('Captcha incorrecto.');
    }

    $sql = "SELECT id, firstName, lastName, user_type, password, company_id, branch_id FROM employees WHERE email = ?";
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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['firstName'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['user_company'] = $user['company_id'];
            $_SESSION['user_branch'] = $user['branch_id'];
            header("Location: ../employee-options/employee-options.php"); // Redirige al dashboard o página inicial
            exit;
        } else {
            echo "Credenciales inválidas.";
        }
    } else {
        echo "Credenciales inválidas.";
    }
    $conn->close();
}
