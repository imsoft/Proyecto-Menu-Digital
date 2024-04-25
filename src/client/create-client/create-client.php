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
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encripta la contraseña antes de almacenarla

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO `clients` (`firstName`, `lastName`, `surname`, `email`, `phone`, `birthdate`, `gender`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("ssssssss", $firstName, $lastName, $surname, $email, $phone, $birthdate, $gender, $password);

        // Ejecutar el statement
        if ($stmt->execute()) {
            header("Location: ../client-options/client-options.html");
            exit;
            // echo "Nuevo cliente registrado exitosamente.";
            // echo '<script type="text/javascript">',
            // 'window.location.href = "../client-options/client-options.html";',
            // '</script>';
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