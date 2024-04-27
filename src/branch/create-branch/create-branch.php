<?php
require '../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $branchName = $_POST['branchName'];
    $branchManager = $_POST['branchManager'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $cellphone = $_POST['cellphone'];
    $website = $_POST['website']; // Asegúrate de manejar adecuadamente si el campo está vacío

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO `branches` (`branch_name`, `branch_manager`, `address`, `postal_code`, `cellphone`, `website`) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("ssssss", $branchName, $branchManager, $address, $postalCode, $cellphone, $website);

        // Ejecutar el statement
        if ($stmt->execute()) {
            header("Location: ../read-branch/read-branch.php"); // Redirigir a una página de éxito
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
