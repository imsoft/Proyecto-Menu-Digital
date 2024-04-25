<?php
require '../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $surname = $_POST['surname'];
    $rfc = $_POST['rfc'];
    $socialName = $_POST['socialName'];
    $tradeName = $_POST['tradeName'];
    $address = $_POST['address'];
    $curp = $_POST['curp'];

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO tax_data (firstName, lastName, surname, rfc, socialName, tradeName, address, curp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("ssssssss", $firstName, $lastName, $surname, $rfc, $socialName, $tradeName, $address, $curp);

        // Ejecutar el statement
        if ($stmt->execute()) {
            header("Location: ../read-tax-data/read-tax-data.php"); // Asumiendo que existe una página de éxito para redirigir
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
