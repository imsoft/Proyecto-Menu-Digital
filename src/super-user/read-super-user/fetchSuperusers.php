<?php
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT id, username, email FROM superusers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-super-user/update-super-user.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No hay superusuarios registrados.</td></tr>";
}
$conn->close();
