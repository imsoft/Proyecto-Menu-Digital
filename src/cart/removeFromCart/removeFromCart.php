<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Por favor inicia sesión.";
    exit;
}

if (!isset($_POST['cartItemId'])) {
    echo "ID de elemento de carrito no proporcionado.";
    exit;
}

$cart_item_id = $_POST['cartItemId'];

// Verificar que el item pertenece al usuario actual
$sql = "SELECT ci.id FROM cart_items ci 
        JOIN carts c ON ci.cart_id = c.id 
        WHERE ci.id = ? AND c.client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_item_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Elemento de carrito no encontrado o no pertenece al usuario.";
    $stmt->close();
    $conn->close();
    exit;
}

// Eliminar los ingredientes asociados del item del carrito
$sql = "DELETE FROM cart_item_ingredients WHERE cart_item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_item_id);

if (!$stmt->execute()) {
    echo "Error al eliminar los ingredientes del producto: " . $conn->error;
    $stmt->close();
    $conn->close();
    exit;
}

// Eliminar el item del carrito
$sql = "DELETE FROM cart_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_item_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error al eliminar el producto: " . $conn->error;
}

$stmt->close();
$conn->close();
