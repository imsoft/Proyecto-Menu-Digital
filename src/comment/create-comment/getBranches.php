<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php'; // Asegúrate de que la ruta es correcta.

$companyId = isset($_GET['companyId']) ? intval($_GET['companyId']) : 0;
$sql = "SELECT id, branch_name FROM branches WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

$branches = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($branches);
$stmt->close();
$conn->close();
?>
