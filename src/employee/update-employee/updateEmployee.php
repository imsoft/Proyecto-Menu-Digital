<?php
require '../../db/connection.php';

// Asumiendo que todos los datos necesarios son recibidos
$id = $_POST['id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$birthdate = $_POST['birthdate'];
$gender = $_POST['gender'];
$password = $_POST['password']; // Encripta la contraseña antes de almacenarla

$stmt = $conn->prepare("UPDATE employees SET firstName = ?, lastName = ?, surname = ?, email = ?, phone = ?, birthdate = ?, gender = ?, password = ? WHERE id = ?");
$stmt->bind_param("ssssssssi", $firstName, $lastName, $surname, $email, $phone, $birthdate, $gender, $password, $id);
if ($stmt->execute()) {
    echo "Empleado actualizado correctamente.";
} else {
    echo "Error al actualizar el empleado: " . $stmt->error;
}

$stmt->close();
$conn->close();
