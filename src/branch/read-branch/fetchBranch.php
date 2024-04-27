<?php
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT id, branch_name, branch_manager, address, postal_code, cellphone, website FROM branches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['branch_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['branch_manager']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['postal_code']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cellphone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['website']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-branch/update-branch.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No hay sucursales registradas.</td></tr>";
}
$conn->close();
