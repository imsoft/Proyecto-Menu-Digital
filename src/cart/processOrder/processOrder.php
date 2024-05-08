<?php
session_start();
require '../../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartId = $_POST['cartId'];
    $clientId = $_SESSION['user_id'];
    $companyId = $_POST['companyId'];
    $branchId = $_POST['branchId'];

    if (!$companyId || !$branchId) {
        die('Error: Falta información de la empresa o la sucursal.');
    }

    $sql = "INSERT INTO orders (cart_id, client_id, company_id, branch_id, state) VALUES (?, ?, ?, ?, 'esperando')";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('iiii', $cartId, $clientId, $companyId, $branchId);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
