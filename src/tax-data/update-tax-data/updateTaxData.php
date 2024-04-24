<?php
require '../../db/connection.php';

// Asumiendo que todos los datos necesarios son recibidos
$id = $_POST['id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$surname = $_POST['surname'];
$rfc = $_POST['rfc'];
$socialName = $_POST['socialName'];
$tradeName = $_POST['tradeName'];
$address = $_POST['address'];
$curp = $_POST['curp'];

// Preparar la consulta SQL para actualizar los datos
$stmt = $conn->prepare("UPDATE tax_data SET firstName = ?, lastName = ?, surname = ?, rfc = ?, socialName = ?, tradeName = ?, address = ?, curp = ? WHERE id = ?");
$stmt->bind_param("ssssssssi", $firstName, $lastName, $surname, $rfc, $socialName, $tradeName, $address, $curp, $id);
error_log("Recibidos: " . print_r($_POST, true));  // Registrar datos recibidos para depuración
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../read-tax-data/read-tax-data.php"); // Redirigir a la página de lectura de datos fiscales
        exit;
    } else {
        echo "No se realizaron cambios en los datos fiscales.";
    }
} else {
    echo "Error al actualizar los datos fiscales: " . $stmt->error;
}

$stmt->close();
$conn->close();
