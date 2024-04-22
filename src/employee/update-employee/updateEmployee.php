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
error_log("Recibidos: " . print_r($_POST, true));
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../read-employee/read-employee.php"); // Redirección desde PHP
        exit; // Asegúrate de llamar a exit después de header para detener la ejecución del script
        // echo '<script type="text/javascript">',
        // 'alert("Empleado actualizado correctamente.");',
        // 'window.location.href = "../read-employee/read-employee.php";',
        // '</script>';
    } else {
        echo "No se realizaron cambios en el empleado.";
    }
} else {
    echo "Error al actualizar el empleado: " . $stmt->error;
}


$stmt->close();
$conn->close();
