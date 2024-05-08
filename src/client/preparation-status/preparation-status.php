<?php
session_start();
require '../../db/connection.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatus de preparación</title>
    <link rel="stylesheet" href="preparation-status.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Estado del Pedido</h1>
        <?php
        session_start();
        require '../../db/connection.php';

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $clientId = $_SESSION['user_id'];
        $sql = "SELECT 
        o.id AS folio, 
        o.state AS status, 
        mi.product_name AS dish, 
        c.table_number
    FROM orders o
    JOIN cart_items ci ON o.cart_id = ci.cart_id
    JOIN menu_items mi ON ci.menu_item_id = mi.id
    JOIN clients c ON o.client_id = c.id
    WHERE o.client_id = ?;
    ";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparando la consulta: " . $conn->error);
        }
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        if (!$stmt->execute()) {
            die("Error ejecutando la consulta: " . $stmt->error);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div id='orderDetails'>";
                echo "<p><strong>Mesa:</strong> <span id='tableNumber'>" . htmlspecialchars($row['table_number']) . "</span></p>";
                echo "<p><strong>Platillo:</strong> <span id='dishName'>" . htmlspecialchars($row['dish']) . "</span></p>";
                echo "<p><strong>Folio:</strong> <span id='folioNumber'>" . htmlspecialchars($row['folio']) . "</span></p>";
                echo "<p><strong>Estado:</strong> <span id='orderStatus'>" . htmlspecialchars($row['status']) . "</span></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No se encontraron pedidos.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>

</html>