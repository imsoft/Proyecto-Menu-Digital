<?php
require '../../../db/connection.php';

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

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE clients SET firstName = ?, lastName = ?, surname = ?, email = ?, phone = ?, birthdate = ?, gender = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("sssssssi", $firstName, $lastName, $surname, $email, $phone, $birthdate, $gender, $id);

        // Ejecutar el statement
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: ../read-clients/read-clients.php"); // Redirección desde PHP
                exit;
            } else {
                echo "No se realizaron cambios en el cliente.";
            }
        } else {
            echo "Error al actualizar el cliente: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
