<?php
session_start();
require '../../../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $companyId = $_SESSION['company_id'];

    $sql = "INSERT INTO ingredients (name, price, company_id) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sdi", $name, $price, $companyId);
        if ($stmt->execute()) {
            header("Location: ../read-company-ingredients/read-company-ingredients.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    $conn->close();
}
