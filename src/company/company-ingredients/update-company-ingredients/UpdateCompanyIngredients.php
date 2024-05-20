<?php
session_start();
require '../../../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $companyId = $_SESSION['company_id'];

    $sql = "UPDATE ingredients SET name = ?, price = ? WHERE id = ? AND company_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sdii", $name, $price, $id, $companyId);
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
?>
