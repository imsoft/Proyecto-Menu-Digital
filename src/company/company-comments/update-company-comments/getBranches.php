<?php
require '../../../db/connection.php';

$company_id = $_GET['company_id'] ?? '';

if ($company_id) {
    $stmt = $conn->prepare("SELECT id, branch_name FROM branches WHERE company_id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $branches = [];
    while ($branch = $result->fetch_assoc()) {
        $branches[] = $branch;
    }
    $stmt->close();

    echo json_encode($branches);
} else {
    echo json_encode([]);
}

$conn->close();
