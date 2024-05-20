<?php
require '../../db/connection.php';

$businessId = isset($_GET['business_id']) ? intval($_GET['business_id']) : 0;

if ($businessId > 0) {
    $sql = "SELECT id, branch_name FROM branches WHERE company_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $businessId);
    $stmt->execute();
    $result = $stmt->get_result();

    $branches = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $branches[] = $row;
        }
    }
    $stmt->close();
    $conn->close();

    echo json_encode($branches);
}
