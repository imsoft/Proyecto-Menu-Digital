<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die("Es necesario iniciar sesión.");
}

$user_id = $_SESSION['user_id'];
$menu_item_id = isset($_POST['menuItemId']) ? intval($_POST['menuItemId']) : 0;
$quantity = 1; // Cantidad a añadir cada vez que se haga clic en "Añadir al carrito"

// Obtener o crear carrito
$sql = "SELECT id FROM carts WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cart_id = $row['id'];
} else {
    // Crear un nuevo carrito si no existe
    $sql = "INSERT INTO carts (client_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id; // ID del nuevo carrito
}

// Añadir al carrito o actualizar la cantidad si el producto ya existe en el carrito
$sql = "SELECT id, quantity FROM cart_items WHERE cart_id = ? AND menu_item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $menu_item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Producto ya en carrito, actualizar cantidad
    $new_quantity = $row['quantity'] + $quantity;
    $sql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_quantity, $row['id']);
    $stmt->execute();
} else {
    // Producto nuevo, insertar en carrito
    $sql = "INSERT INTO cart_items (cart_id, menu_item_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $cart_id, $menu_item_id, $quantity);
    $stmt->execute();
}

echo "Producto añadido al carrito.";
$conn->close();
