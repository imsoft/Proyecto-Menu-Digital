<?php
session_start();
require '../../db/connection.php';  // Asegúrate que la ruta de conexión es correcta

$companyId = $_SESSION['company_id'];  // Tomamos el ID de la compañía desde la sesión

// Consulta para obtener los pedidos entregados
$sql = "SELECT o.id, o.created_at, mi.product_name, mi.price, b.branch_name, o.state
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN branches b ON o.branch_id = b.id
        WHERE o.company_id = ? AND o.state = 'entregada'
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("i", $companyId);
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

echo json_encode($orders);  // Devolvemos los resultados como JSON para ser consumidos por JavaScript

$stmt->close();
$conn->close();
?>
