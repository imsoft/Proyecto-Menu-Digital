<?php
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT id, product_image, product_name, description, category_name, price FROM menu_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' alt='Imagen del Producto' style='width:100px; height:auto;'></td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-menu/update-menu.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay productos registrados.</td></tr>";
}
$conn->close();
