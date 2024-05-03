<?php
require '../../db/connection.php';

// Comenzar la sesión
session_start();

// Asegurarse de que el método usado es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $commentId = $data['id'];
    $userId = $_SESSION['user_id'];

    // Verificar que el ID del comentario fue recibido correctamente
    if (!$commentId) {
        echo json_encode(['success' => false, 'error' => 'No comment ID provided']);
        exit;
    }

    // Preparar la consulta SQL para eliminar el comentario
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND client_id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
        exit;
    }

    // Vincular parámetros y ejecutar
    $stmt->bind_param("ii", $commentId, $userId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error executing statement: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
