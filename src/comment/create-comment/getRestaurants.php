<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';  // Asegúrate de que la ruta es correcta.

$sql = "SELECT id, business_name AS name FROM companies";
$result = $conn->query($sql);

$restaurants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $restaurants[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($restaurants);
$conn->close();
?>
