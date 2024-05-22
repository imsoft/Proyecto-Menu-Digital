<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['user_company'];
$branchId = $_SESSION['user_branch'];

$sql = "SELECT 
        o.id AS folio, 
        o.state AS status, 
        mi.product_name AS dish, 
        mi.product_image AS image, 
        c.table_number
    FROM orders o
    JOIN cart_items ci ON o.cart_id = ci.cart_id
    JOIN menu_items mi ON ci.menu_item_id = mi.id
    JOIN clients c ON o.client_id = c.id
    WHERE o.company_id = ? AND o.branch_id = ?
    ORDER BY o.state DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("ii", $companyId, $branchId);
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
