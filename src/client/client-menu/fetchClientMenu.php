<?php
require '../../db/connection.php'; // Asegúrate de que la ruta al archivo de conexión es correcta

$type = isset($_GET['type']) ? $_GET['type'] : '';
$sql = "SELECT id, product_image, product_name, description, category_name, price FROM menu_items";
if ($type) {
    $sql .= " WHERE category_name = '" . $conn->real_escape_string($type) . "'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo '<div class="menu-item">';
        echo '<img src="' . htmlspecialchars($row['product_image']) . '" alt="Imagen del Producto">';
        echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p>Categoría: ' . htmlspecialchars($row['category_name']) . '</p>';
        echo '<p>Precio: $' . htmlspecialchars($row['price']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<div>No hay productos registrados.</div>';
}
$conn->close();
