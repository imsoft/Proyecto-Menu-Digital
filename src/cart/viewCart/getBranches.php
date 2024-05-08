<?php
require '../../db/connection.php'; // Asegúrate de tener la ruta correcta

if (isset($_GET['company_id'])) {
    $companyId = intval($_GET['company_id']);

    $sql = "SELECT id, branch_name FROM branches WHERE company_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $companyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $branches = [];

    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }

    echo json_encode($branches);
}
?>
