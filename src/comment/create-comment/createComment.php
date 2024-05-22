<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die("Por favor inicia sesión para dejar un comentario.");
}

if (!isset($_POST['rating'], $_POST['commentBox'])) {
    die("Todos los campos son necesarios.");
}

$client_id = $_SESSION['user_id'];
$branch_id = isset($_POST['branch']) && intval($_POST['branch']) > 0 ? intval($_POST['branch']) : null;
$rating = $_POST['rating'];
$comment = $_POST['commentBox'];

$sql = "INSERT INTO comments (client_id, branch_id, rating, comment) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparando la consulta: " . $conn->error);
}

if ($branch_id !== null) {
    $stmt->bind_param("iiss", $client_id, $branch_id, $rating, $comment);
} else {
    $stmt->bind_param("isss", $client_id, $branch_id, $rating, $comment);
}

if (!$stmt->execute()) {
    die("Error ejecutando la consulta: " . $stmt->error);
}

header("Location: ../../client/client-options/client-options.php");
exit;

$stmt->close();
$conn->close();
?>
