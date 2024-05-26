<?php
require '../../../db/connection.php';

// Asegurarse de que el método usado es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($conn === false) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $branchId = $data['id'];

    // Preparar la consulta SQL para eliminar el registro
    $stmt = $conn->prepare("DELETE FROM branches WHERE id = ?");
    $stmt->bind_param("i", $branchId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        error_log("Error al ejecutar la consulta: " . $stmt->error);  // Log del error SQL
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
