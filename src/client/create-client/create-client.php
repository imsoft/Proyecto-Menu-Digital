<?php
require '../../db/connection.php'; // Asegúrate de que la ruta al archivo es correcta

// Recibir datos del formulario
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$birthdate = $_POST['birthdate'];
$gender = $_POST['gender'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña

// Preparar y vincular parámetros
$stmt = $conn->prepare("INSERT INTO clients (firstName, lastName, surname, email, phone, birthdate, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $firstName, $lastName, $surname, $email, $phone, $birthdate, $gender, $password);

// Ejecutar y verificar
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
