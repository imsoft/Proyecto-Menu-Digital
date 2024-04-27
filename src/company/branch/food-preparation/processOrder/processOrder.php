<?php
session_start();
require '../../../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die("Por favor inicia sesión para procesar el pedido.");
}

if (!isset($_POST['cartId'])) {
    die("No se proporcionó el ID del carrito.");
}

$cart_id = $_POST['cartId'];

// Intenta actualizar el estado del carrito o procesar el pedido
$sql = "UPDATE carts SET status = 'processing' WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparando la consulta: " . $conn->error);
}

$stmt->bind_param("i", $cart_id);
if (!$stmt->execute()) {
    die("Error ejecutando la consulta: " . $stmt->error);
}

echo "success";

$conn->close();
