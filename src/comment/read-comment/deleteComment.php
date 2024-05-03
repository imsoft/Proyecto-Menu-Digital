<?php
require '../../db/connection.php';
session_start();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $commentId = $data['id'];

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Session not set']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND client_id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
        exit;
    }

    $stmt->bind_param("ii", $commentId, $_SESSION['user_id']);
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['error'] = 'Failed to execute statement';
    }

    $stmt->close();
} else {
    $response['error'] = 'Invalid request method';
}

$conn->close();
echo json_encode($response);
