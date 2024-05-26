<?php
require '../../../db/connection.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Recuperar los valores del formulario
$id = $_POST['id'];
$branch_name = $_POST['branch_name'];
$branch_manager = $_POST['branch_manager'];
$address = $_POST['address'];
$postal_code = $_POST['postal_code'];
$cellphone = $_POST['cellphone'];
$website = $_POST['website'];
$company_id = $_POST['company_id'];

// Preparar la consulta SQL para actualizar los datos
$sql = "UPDATE branches SET branch_name = ?, branch_manager = ?, address = ?, postal_code = ?, cellphone = ?, website = ?, company_id = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
// Vincular los valores como parámetros al statement preparado
$stmt->bind_param("ssssssii", $branch_name, $branch_manager, $address, $postal_code, $cellphone, $website, $company_id, $id);

// Ejecutar el statement
if ($stmt->execute()) {
if ($stmt->affected_rows > 0) {
header("Location: ../read-branches/read-branches.php"); // Redirección desde PHP
exit;
} else {
echo "No se realizaron cambios en la sucursal.";
}
} else {
echo "Error al actualizar la sucursal: " . $stmt->error;
}

// Cerrar el statement
$stmt->close();
} else {
echo "Error preparando la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
}