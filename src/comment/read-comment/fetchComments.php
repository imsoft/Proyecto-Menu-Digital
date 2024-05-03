<?php
require '../../db/connection.php'; // Asegúrate de que la ruta es correcta

session_start();

$clientId = $_SESSION['user_id'];

$sql = "SELECT id, rating, comment, created_at FROM comments WHERE client_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->bind_param("i", $clientId);

if (!$stmt->execute()) {
    die('Error executing statement: ' . $stmt->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
        echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-comment/update-comment.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No has hecho comentarios aún.</td></tr>";
}
$conn->close();
