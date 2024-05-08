<?php
session_start();
require '../../db/connection.php';

$orderId = $_POST['orderId'];
$newState = $_POST['newState'];

$sql = "UPDATE orders SET state = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo 'Error al preparar la consulta: ' . $conn->error;
    exit;
}
$stmt->bind_param("si", $newState, $orderId);
if ($stmt->execute()) {
    echo 'Estado actualizado correctamente';
} else {
    echo 'Error al actualizar el estado: ' . $stmt->error;
}

$stmt->close();
$conn->close();
