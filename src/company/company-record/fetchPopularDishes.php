<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['company_id'];

$sql = "SELECT mi.product_name, SUM(ci.quantity) as quantity
        FROM cart_items ci
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN orders o ON ci.cart_id = o.cart_id
        WHERE o.company_id = ?
        GROUP BY mi.product_name
        ORDER BY quantity DESC
        LIMIT 10";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("i", $companyId);
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
$result = $stmt->get_result();

$popularDishes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $popularDishes[] = $row;
    }
}

echo json_encode($popularDishes);

$stmt->close();
$conn->close();
