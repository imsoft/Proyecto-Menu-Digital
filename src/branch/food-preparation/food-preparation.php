<?php
session_start();
require '../../db/connection.php'; // Ajusta esta ruta según la ubicación real del archivo

$companyId = $_SESSION['user_company'];
$branchId = $_SESSION['user_branch'];

$sql = "SELECT 
        o.id AS folio, 
        o.state AS status, 
        mi.product_name AS dish, 
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
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
$result = $stmt->get_result();

$orders = ['esperando' => [], 'preparando' => [], 'lista' => [], 'entregada' => []];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[$row['status']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparación de alimentos</title>
    <link rel="stylesheet" href="food-preparation.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Estado de Preparación de los Alimentos</h1>
        <div id="preparationStatus">
            <section id="waiting">
                <h2>Esperando</h2>
                <ul>
                    <?php foreach ($orders['esperando'] as $order) { ?>
                        <li><?php echo htmlspecialchars($order['dish']) . " (Orden #" . $order['folio'] . ")"; ?>
                            <button onclick="updateOrderStatus(<?php echo $order['folio']; ?>, 'preparando')">Mover a Preparación</button>
                        </li>
                    <?php } ?>
                </ul>
            </section>
            <section id="inPreparation">
                <h2>Preparando</h2>
                <ul>
                    <?php foreach ($orders['preparando'] as $order) { ?>
                        <li><?php echo htmlspecialchars($order['dish']) . " (Orden #" . $order['folio'] . ")"; ?>
                            <button onclick="updateOrderStatus(<?php echo $order['folio']; ?>, 'lista')">Mover a Listo para Servir</button>
                        </li>
                    <?php } ?>
                </ul>
            </section>
            <section id="ready">
                <h2>Listos para Servir</h2>
                <ul>
                    <?php foreach ($orders['lista'] as $order) { ?>
                        <li><?php echo htmlspecialchars($order['dish']) . " (Orden #" . $order['folio'] . ")"; ?>
                            <button onclick="updateOrderStatus(<?php echo $order['folio']; ?>, 'entregada')">Mover a Entregada</button>
                        </li>
                    <?php } ?>
                </ul>
            </section>

            <section id="delivered">
                <h2>Entregadas</h2>
                <ul>
                    <?php foreach ($orders['entregada'] as $order) { ?>
                        <li><?php echo htmlspecialchars($order['dish']) . " (Orden #" . $order['folio'] . ")"; ?></li>
                    <?php } ?>
                </ul>
            </section>

        </div>
    </div>
    <script src="food-preparation.js"></script>
</body>

</html>