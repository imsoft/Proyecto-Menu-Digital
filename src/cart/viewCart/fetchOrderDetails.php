<?php
require '../../db/connection.php';
session_start();

if (!isset($_POST['cartId'])) {
    echo "No se ha proporcionado un ID de carrito.";
    exit;
}

$cart_id = $_POST['cartId'];

// Obtener los items del carrito
$sql = "SELECT mi.product_name, mi.product_image, mi.price, ci.quantity
        FROM cart_items ci
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        WHERE ci.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();

$total_sum = 0; // Variable para almacenar la suma total de los productos en el carrito

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $total = $row['price'] * $row['quantity'];
        $total_sum += $total; // Sumar al total general
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' class='product-image'> " . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>$" . number_format($row['price'], 2) . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>$" . number_format($total, 2) . "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td colspan='3' class='total-label'><strong>Total:</strong></td>";
    echo "<td>$" . number_format($total_sum, 2) . "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "No hay productos en tu carrito.";
}

$stmt->close();
$conn->close();
