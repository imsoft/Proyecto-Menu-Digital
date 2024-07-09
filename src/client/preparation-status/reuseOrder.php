<?php
session_start();
require '../../db/connection.php';

$folio = isset($_GET['folio']) ? intval($_GET['folio']) : 0;

if ($folio <= 0) {
    echo json_encode(['success' => false, 'message' => 'Folio inválido']);
    exit;
}

// Obtener los detalles del pedido original
$sql = "SELECT cart_id FROM orders WHERE id = ? AND company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $folio, $_SESSION['user_company']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
    exit;
}

$row = $result->fetch_assoc();
$originalCartId = $row['cart_id'];
$stmt->close();

// Crear un nuevo pedido basado en el original
$sql = "INSERT INTO orders (client_id, company_id, branch_id, cart_id, state) 
        SELECT client_id, company_id, branch_id, ?, 'esperando' 
        FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);

// Crear un nuevo carrito
$newCartId = null;
$conn->begin_transaction();
try {
    $sqlCart = "INSERT INTO carts (client_id, total_price, status) 
                SELECT client_id, total_price, status 
                FROM carts WHERE id = ?";
    $stmtCart = $conn->prepare($sqlCart);
    $stmtCart->bind_param("i", $originalCartId);
    $stmtCart->execute();
    $newCartId = $stmtCart->insert_id;
    $stmtCart->close();

    $stmt->bind_param("ii", $newCartId, $folio);
    $stmt->execute();
    $stmt->close();

    // Copiar los artículos del carrito original al nuevo carrito
    $sqlItems = "INSERT INTO cart_items (cart_id, menu_item_id, quantity, price) 
                 SELECT ?, menu_item_id, quantity, price 
                 FROM cart_items WHERE cart_id = ?";
    $stmtItems = $conn->prepare($sqlItems);
    $stmtItems->bind_param("ii", $newCartId, $originalCartId);
    $stmtItems->execute();
    $stmtItems->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Pedido reutilizado con éxito']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error al reutilizar el pedido: ' . $e->getMessage()]);
}

$conn->close();
?>
