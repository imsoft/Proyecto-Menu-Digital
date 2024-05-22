<?php
session_start();
require '../../db/connection.php';

$clientId = $_SESSION['user_id'];

$sql = "SELECT 
        ci.folio AS folio, 
        o.state AS status, 
        mi.product_name AS dish, 
        mi.product_image AS image, 
        mi.description AS description, 
        c.table_number
    FROM orders o
    JOIN cart_items ci ON o.cart_id = ci.cart_id
    JOIN menu_items mi ON ci.menu_item_id = mi.id
    JOIN clients c ON o.client_id = c.id
    WHERE o.client_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparando la consulta: " . $conn->error);
}
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode($orders);
?>
