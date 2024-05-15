<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['company_id'];
$period = $_GET['period'] ?? 'day';

switch ($period) {
    case 'day':
        $groupBy = "DATE(o.created_at)";
        break;
    case 'month':
        $groupBy = "DATE_FORMAT(o.created_at, '%Y-%m')";
        break;
    case 'year':
        $groupBy = "YEAR(o.created_at)";
        break;
    default:
        $groupBy = "DATE(o.created_at)";
}

$sql = "SELECT $groupBy as date, SUM(mi.price * ci.quantity) as sales
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        WHERE o.company_id = ?
        GROUP BY $groupBy
        ORDER BY date DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("i", $companyId);
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
$result = $stmt->get_result();

$statistics = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statistics[] = $row;
    }
}

echo json_encode($statistics);

$stmt->close();
$conn->close();
