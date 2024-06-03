<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['company_id'];

$sql = "SELECT 
            o.id AS folio, 
            o.state AS status, 
            mi.product_name AS dish, 
            mi.product_image AS image, 
            c.table_number, 
            b.branch_name AS branch
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN clients c ON o.client_id = c.id
        JOIN branches b ON o.branch_id = b.id
        WHERE o.company_id = ?
        ORDER BY b.branch_name, o.state DESC";

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
        $orders[$row['branch']][$row['status']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparación de alimentos</title>
    <link rel="stylesheet" href="company-food-preparation.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../company-menubar/company-menubar.css">
    <script src="../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../company-menubar/company-menubar.php'; ?>
    <div class="container">
        <h1>Estado de Preparación de los Alimentos</h1>
        <div id="preparationStatus">
            <?php foreach ($orders as $branch => $statuses) { ?>
                <section class="branch-section">
                    <h2><?php echo htmlspecialchars($branch); ?></h2>

                    <div class="status-section waiting">
                        <h3>En espera</h3>
                        <div class="order-list">
                            <?php if (isset($statuses['esperando'])) {
                                foreach ($statuses['esperando'] as $order) { ?>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['dish']); ?>">
                                        <?php echo htmlspecialchars($order['dish']) . " (Orden #" . htmlspecialchars($order['folio']) . ", Mesa #" . htmlspecialchars($order['table_number']) . ")"; ?>
                                        <button onclick="updateOrderStatus(<?php echo $order['folio']; ?>, 'preparando')">Mover a Preparación</button>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="order-item">No hay pedidos en espera.</div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="status-section preparing">
                        <h3>Preparando</h3>
                        <div class="order-list">
                            <?php if (isset($statuses['preparando'])) {
                                foreach ($statuses['preparando'] as $order) { ?>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['dish']); ?>">
                                        <?php echo htmlspecialchars($order['dish']) . " (Orden #" . htmlspecialchars($order['folio']) . ", Mesa #" . htmlspecialchars($order['table_number']) . ")"; ?>
                                        <button onclick="updateOrderStatus(<?php echo $order['folio']; ?>, 'lista')">Mover a Listo para Servir</button>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="order-item">No hay pedidos en preparación.</div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="status-section ready">
                        <h3>Listos para Servir</h3>
                        <div class="order-list">
                            <?php if (isset($statuses['lista'])) {
                                foreach ($statuses['lista'] as $order) { ?>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['dish']); ?>">
                                        <?php echo htmlspecialchars($order['dish']) . " (Orden #" . htmlspecialchars($order['folio']) . ", Mesa #" . htmlspecialchars($order['table_number']) . ")"; ?>
                                        <button onclick="updateOrderStatus(<?php echo $order['folio']; ?>, 'entregada')">Mover a Entregada</button>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="order-item">No hay pedidos listos para servir.</div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="status-section delivered">
                        <h3>Entregadas</h3>
                        <div class="order-list">
                            <?php if (isset($statuses['entregada'])) {
                                foreach ($statuses['entregada'] as $order) { ?>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['dish']); ?>">
                                        <?php echo htmlspecialchars($order['dish']) . " (Orden #" . htmlspecialchars($order['folio']) . ", Mesa #" . htmlspecialchars($order['table_number']) . ")"; ?>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="order-item">No hay pedidos entregados.</div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>
    </div>
    <script src="company-food-preparation.js"></script>
</body>

</html>