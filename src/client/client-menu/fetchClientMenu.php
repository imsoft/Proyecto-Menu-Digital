<?php
session_start(); // Asegura que la sesión esté iniciada
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

if (!isset($_SESSION['company_id'])) {
    echo "No se encontró company_id en la sesión.";
    exit;
}

$companyId = $_SESSION['company_id']; // Obtén el company_id de la sesión
$clientId = $_SESSION['user_id']; // Obtén el user_id de la sesión

$type = isset($_GET['type']) ? $_GET['type'] : '';

// Consulta para obtener las compras frecuentes
$frequentItemsSql = "
    SELECT mi.id, mi.product_image, mi.product_name, mi.description, mi.category_name, mi.price, COUNT(oi.menu_item_id) as purchase_count
    FROM cart_items oi
    JOIN menu_items mi ON oi.menu_item_id = mi.id
    JOIN carts o ON oi.cart_id = o.id
    WHERE o.client_id = ? AND mi.category_name = ?
    GROUP BY mi.id
    ORDER BY purchase_count DESC
    LIMIT 5
";
$frequentItemsStmt = $conn->prepare($frequentItemsSql);

if (!$frequentItemsStmt) {
    die("Error en la preparación de la consulta para las compras frecuentes: " . $conn->error);
}

$frequentItemsStmt->bind_param("is", $clientId, $type);
$frequentItemsStmt->execute();
$frequentItemsResult = $frequentItemsStmt->get_result();

$frequentItems = [];
while ($row = $frequentItemsResult->fetch_assoc()) {
    $frequentItems[] = $row['id'];
}

// Consulta para obtener todos los ítems del menú
$sql = "SELECT id, product_image, product_name, description, category_name, price FROM menu_items WHERE company_id = ?";
$params = [$companyId];

if ($type) {
    $sql .= " AND category_name = ?";
    $params[] = $type;
}

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la preparación de la consulta para los ítems del menú: " . $conn->error);
}

$types = str_repeat("s", count($params));
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $isFrequent = in_array($row['id'], $frequentItems);
        echo '<div class="menu-item">';
        echo '<img src="' . htmlspecialchars($row['product_image']) . '" alt="Imagen del Producto">';
        echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p>Categoría: ' . htmlspecialchars($row['category_name']) . '</p>';
        echo '<p>Precio: $' . htmlspecialchars($row['price']) . '</p>';
        if ($isFrequent) {
            echo '<p class="frequent-purchase">Compra Frecuente</p>';
        }
        echo '<button class="add-to-cart-btn" onclick="addToCart(' . $row['id'] . ')">Añadir al Carrito</button>';
        echo '</div>';
    }
} else {
    echo '<div>No hay productos registrados.</div>';
}

$frequentItemsStmt->close();
$stmt->close();
$conn->close();
