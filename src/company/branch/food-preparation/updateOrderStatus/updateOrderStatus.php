<?php
session_start();
require '../../../../db/connection.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['orderId']) || !isset($_POST['newStatus'])) {
    echo "Faltan datos necesarios.";
    exit;
}

$order_id = $_POST['orderId'];
$new_status = $_POST['newStatus'];

$sql = "UPDATE orders SET state = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_status, $order_id);

if ($stmt->execute()) {
    echo "Estado actualizado correctamente.";
} else {
    echo "Error al actualizar el estado.";
}

$conn->close();
