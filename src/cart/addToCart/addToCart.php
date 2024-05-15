<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die("Es necesario iniciar sesión.");
}

$user_id = $_SESSION['user_id'];
$menu_item_id = isset($_POST['menuItemId']) ? intval($_POST['menuItemId']) : 0;
$quantity = 1; // Cantidad a añadir cada vez que se haga clic en "Añadir al carrito"
$ingredients = isset($_POST['ingredients']) ? $_POST['ingredients'] : [];

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
    // Generar un folio único
    $folio = mt_rand(100000, 999999); // Generar un folio aleatorio de 6 dígitos
    // Verificar que el folio sea único
    $sql = "SELECT COUNT(*) as count FROM cart_items WHERE folio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $folio);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    while ($row['count'] > 0) {
        // Si el folio no es único, generar uno nuevo
        $folio = mt_rand(100000, 999999);
        $stmt->bind_param("i", $folio);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }

    // Producto nuevo, insertar en carrito
    $sql = "INSERT INTO cart_items (cart_id, menu_item_id, quantity, folio) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $cart_id, $menu_item_id, $quantity, $folio);
    $stmt->execute();
    $cart_item_id = $stmt->insert_id;

    // Añadir ingredientes seleccionados al carrito
    foreach ($ingredients as $ingredient) {
        $sql = "INSERT INTO cart_item_ingredients (cart_item_id, ingredient) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $cart_item_id, $ingredient);
        $stmt->execute();
    }
}

// Redirigir a la página de ver carrito
header("Location: ../viewCart/viewCart.php");
exit();

$conn->close();
