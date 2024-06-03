<?php
session_start(); // Asegura que la sesión esté iniciada
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

if (!isset($_SESSION['company_id'])) {
    echo "No se encontró company_id en la sesión.";
    exit;
}

$companyId = $_SESSION['company_id']; // Obtén el company_id de la sesión

$type = isset($_GET['type']) ? $_GET['type'] : '';
$sql = "SELECT id, product_image, product_name, description, category_name, price FROM menu_items WHERE company_id = ?";
$params = [$companyId];

if ($type) {
    $sql .= " AND category_name = ?";
    $params[] = $type;
}

$stmt = $conn->prepare($sql);
$types = str_repeat("s", count($params));
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo '<div class="menu-item">';
        echo '<img src="' . htmlspecialchars($row['product_image']) . '" alt="Imagen del Producto">';
        echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p>Categoría: ' . htmlspecialchars($row['category_name']) . '</p>';
        echo '<p>Precio: $' . htmlspecialchars($row['price']) . '</p>';
        echo '<button class="add-to-cart-btn" onclick="addToCart(' . $row['id'] . ')">Añadir al Carrito</button>';
        echo '</div>';
    }
} else {
    echo '<div>No hay productos registrados.</div>';
}

$stmt->close();
$conn->close();
