<?php
session_start();
require '../../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartId = $_POST['cartId'];
    $clientId = $_SESSION['user_id'];
    $companyId = $_POST['companyId'];
    $branchId = isset($_POST['branchId']) ? $_POST['branchId'] : null;

    if (!$companyId) {
        die('Error: Falta información de la empresa.');
    }

    if ($branchId) {
        $sql = "INSERT INTO orders (cart_id, client_id, company_id, branch_id, state) VALUES (?, ?, ?, ?, 'esperando')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiii', $cartId, $clientId, $companyId, $branchId);
    } else {
        $sql = "INSERT INTO orders (cart_id, client_id, company_id, state) VALUES (?, ?, ?, 'esperando')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $cartId, $clientId, $companyId);
    }

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
