<?php
session_start();
require '../../db/connection.php';

$folio = isset($_GET['folio']) ? intval($_GET['folio']) : 0;

if ($folio <= 0) {
    echo "Folio inválido";
    exit;
}

$sql = "SELECT o.id AS folio, o.created_at, mi.product_name AS dish, mi.price, c.table_number, cl.email
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN clients c ON o.client_id = c.id
        JOIN clients cl ON o.client_id = cl.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $folio);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Pedido no encontrado";
    exit;
}

$order = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <title>Ticket del Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin: 100px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin: 0 0 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h1>Ticket del Pedido</h1>
        <p><strong>Folio:</strong> <?php echo htmlspecialchars($order['folio']); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
        <p><strong>Mesa:</strong> <?php echo htmlspecialchars($order['table_number']); ?></p>
        <p><strong>Platillo:</strong> <?php echo htmlspecialchars($order['dish']); ?></p>
        <p><strong>Precio:</strong> $<?php echo htmlspecialchars($order['price']); ?></p>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
    </div>
</body>

</html>