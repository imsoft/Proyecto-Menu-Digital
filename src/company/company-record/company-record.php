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

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link rel="stylesheet" href="company-record.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Historial de Pedidos</h1>
        <div id="orderHistory">
            <?php if (count($orders) > 0) : ?>
                <?php foreach ($orders as $order) : ?>
                    <div class="order">
                        <p><strong>ID del Pedido:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                        <p><strong>Producto:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
                        <p><strong>Precio:</strong> $<?php echo number_format($order['price'], 2); ?></p>
                        <p><strong>Sucursal:</strong> <?php echo htmlspecialchars($order['branch_name']); ?></p>
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($order['state']); ?></p>
                        <p><strong>Fecha de Entrega:</strong> <?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay pedidos entregados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>