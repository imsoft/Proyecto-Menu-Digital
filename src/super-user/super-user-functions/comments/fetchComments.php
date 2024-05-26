<?php
require '../../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT id, client_id, branch_id, rating, comment, created_at, company_id FROM comments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['client_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['branch_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
        echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($row['company_id']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-comment.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No hay comentarios registrados.</td></tr>";
}
$conn->close();
