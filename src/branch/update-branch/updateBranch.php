<?php
require '../../db/connection.php';

// Asumiendo que todos los datos necesarios son recibidos
$id = $_POST['id'];
$branchName = $_POST['branchName'];
$branchManager = $_POST['branchManager'];
$address = $_POST['address'];
$postalCode = $_POST['postalCode'];
$cellphone = $_POST['cellphone'];
$website = $_POST['website'];  // Asegúrate de manejar correctamente los campos opcionales

$stmt = $conn->prepare("UPDATE branches SET branch_name = ?, branch_manager = ?, address = ?, postal_code = ?, cellphone = ?, website = ? WHERE id = ?");
$stmt->bind_param("ssssssi", $branchName, $branchManager, $address, $postalCode, $cellphone, $website, $id);
error_log("Recibidos: " . print_r($_POST, true));  // Log de información recibida para depuración
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../read-branch/read-branch.php"); // Redirección a la página de sucursales
        exit;
    } else {
        echo "No se realizaron cambios en la sucursal.";
    }
} else {
    echo "Error al actualizar la sucursal: " . $stmt->error;
}

$stmt->close();
$conn->close();
