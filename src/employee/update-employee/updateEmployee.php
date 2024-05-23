<?php
require '../../db/connection.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
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

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE employees SET firstName = ?, lastName = ?, surname = ?, email = ?, phone = ?, birthdate = ?, gender = ?, password = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("ssssssssi", $firstName, $lastName, $surname, $email, $phone, $birthdate, $gender, $hashedPassword, $id);

        // Ejecutar el statement
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: ../read-employee/read-employee.php"); // Redirección desde PHP
                exit;
            } else {
                echo "No se realizaron cambios en el empleado.";
            }
        } else {
            echo "Error al actualizar el empleado: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
