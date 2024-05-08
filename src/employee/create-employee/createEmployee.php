<?php
require '../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $companyId = $_POST['company_id'];
    $branchId = !empty($_POST['branch_id']) ? $_POST['branch_id'] : null;
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validar que las contraseñas coinciden
    if ($password !== $confirmPassword) {
        die("Las contraseñas no coinciden.");
    }

    // Validar la contraseña
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/';
    if (!preg_match($passwordRegex, $password)) {
        die("La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.");
    }

    // Encriptar la contraseña antes de almacenarla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO `employees` (`firstName`, `lastName`, `surname`, `email`, `phone`, `birthdate`, `gender`, `password`, `company_id`, `branch_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("ssssssssii", $firstName, $lastName, $surname, $email, $phone, $birthdate, $gender, $hashedPassword, $companyId, $branchId);

        // Ejecutar el statement
        if ($stmt->execute()) {
            // Redireccionar a otra página tras el registro exitoso
            header("Location: ../read-employee/read-employee.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
