<?php
session_start();
require '../../../db/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $companyId = $_SESSION['company_id'];

    $sql = "DELETE FROM ingredients WHERE id = ? AND company_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $id, $companyId);
        if ($stmt->execute()) {
            header("Location: read-company-ingredients.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: read-company-ingredients.php");
}
?>
