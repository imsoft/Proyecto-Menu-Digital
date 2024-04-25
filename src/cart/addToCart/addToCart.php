<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$menuItemId = isset($_POST['menuItemId']) ? intval($_POST['menuItemId']) : 0;
if ($menuItemId > 0) {
    // Asumimos que cada click añade un producto
    if (!isset($_SESSION['cart'][$menuItemId])) {
        $_SESSION['cart'][$menuItemId] = 1; // Inicializar la cantidad
    } else {
        $_SESSION['cart'][$menuItemId]++; // Incrementar la cantidad
    }
    echo "Producto añadido al carrito.";
} else {
    echo "Error en la solicitud.";
}
$conn->close();
