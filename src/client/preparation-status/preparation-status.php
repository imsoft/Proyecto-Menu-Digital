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
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $clientId = $_SESSION['user_id'];
        $sql = "SELECT 
            ci.folio AS folio, 
            o.state AS status, 
            mi.product_name AS dish, 
            mi.product_image AS image, 
            mi.description AS description, 
            c.table_number
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN clients c ON o.client_id = c.id
        WHERE o.client_id = ?";
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
                // Convertir estado a un valor más amigable y asignar clase CSS
                switch ($row['status']) {
                    case 'esperando':
                        $friendly_status = 'En espera';
                        $status_class = 'status-waiting';
                        $progress = 25; // porcentaje de progreso para el estado "esperando"
                        break;
                    case 'preparando':
                        $friendly_status = 'Preparando';
                        $status_class = 'status-preparing';
                        $progress = 50; // porcentaje de progreso para el estado "preparando"
                        break;
                    case 'lista':
                        $friendly_status = 'Lista';
                        $status_class = 'status-ready';
                        $progress = 75; // porcentaje de progreso para el estado "lista"
                        break;
                    case 'entregada':
                        $friendly_status = 'Entregada';
                        $status_class = 'status-delivered';
                        $progress = 100; // porcentaje de progreso para el estado "entregada"
                        break;
                    default:
                        $friendly_status = htmlspecialchars($row['status']);
                        $status_class = '';
                        $progress = 0; // valor por defecto
                        break;
                }

                echo "<div class='orderDetails $status_class'>";
                echo "<p><strong>Mesa:</strong> <span id='tableNumber'>" . htmlspecialchars($row['table_number']) . "</span></p>";
                echo "<p><strong>Platillo:</strong> <span id='dishName'>" . htmlspecialchars($row['dish']) . "</span></p>";
                echo "<p><strong>Descripción:</strong> <span id='description'>" . htmlspecialchars($row['description']) . "</span></p>";
                echo "<p><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['dish']) . "' style='width:100px;'></p>";
                echo "<p><strong>Folio:</strong> <span id='folioNumber'>" . htmlspecialchars($row['folio']) . "</span></p>";
                echo "<p><strong>Estado:</strong> <span id='orderStatus'>" . $friendly_status . "</span></p>";
                echo "<div class='progress-bar'><div class='progress' style='width: $progress%;'><div class='progress-dot'></div></div></div>"; // Barra de progreso con punto
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
