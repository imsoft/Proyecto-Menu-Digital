<?php
session_start();
require '../../db/connection.php';

$companyId = $_SESSION['company_id'];

$sql = "SELECT rating, COUNT(*) as count FROM comments WHERE company_id = ? GROUP BY rating";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = ['rating' => $row['rating'], 'count' => $row['count']];
}

echo json_encode($data);
$conn->close();
?>
