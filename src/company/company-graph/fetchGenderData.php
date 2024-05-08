<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['company_id'];

$sql = "SELECT gender, COUNT(*) as count FROM employees WHERE company_id = ? GROUP BY gender";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = ['gender' => $row['gender'], 'count' => $row['count']];
}

echo json_encode($data);
$conn->close();
?>
