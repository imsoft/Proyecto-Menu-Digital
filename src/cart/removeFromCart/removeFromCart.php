<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Por favor inicia sesión para ver tu carrito.";
    exit;
}

if (!isset($_POST['cartItemId'])) {
    echo "No se especificó el producto a eliminar.";
    exit;
}

$cart_item_id = intval($_POST['cartItemId']);

// Eliminar el ítem del carrito
$sql = "DELETE FROM cart_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_item_id);
if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error al eliminar el producto: " . $stmt->error;
}

$conn->close();
