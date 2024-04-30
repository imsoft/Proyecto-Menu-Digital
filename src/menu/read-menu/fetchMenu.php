<?php
session_start(); // Asegura que la sesión esté iniciada

require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

if (!isset($_SESSION['company_id'])) {
    echo "No se encontró company_id en la sesión.";
    exit;
}

$companyId = $_SESSION['company_id']; // Obtén el company_id de la sesión

$sql = "SELECT id, product_image, product_name, description, category_name, price FROM menu_items WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

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
$stmt->close();
$conn->close();
