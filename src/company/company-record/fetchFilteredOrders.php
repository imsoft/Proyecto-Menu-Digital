<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['company_id'];
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$dish = $_GET['dish'] ?? null;

$sql = "SELECT o.id, o.created_at, mi.product_name, mi.price, mi.product_image, b.branch_name, o.state
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN branches b ON o.branch_id = b.id
        WHERE o.company_id = ?";

$params = [$companyId];
$types = "i";

if ($startDate && $endDate) {
    $sql .= " AND o.created_at BETWEEN ? AND ?";
    $params[] = $startDate;
    $params[] = $endDate;
    $types .= "ss";
}

if ($dish) {
    $sql .= " AND mi.product_name = ?";
    $params[] = $dish;
    $types .= "s";
}

$sql .= " ORDER BY o.created_at DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param($types, ...$params);

if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
$result = $stmt->get_result();

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode($orders);

$stmt->close();
$conn->close();
?>
