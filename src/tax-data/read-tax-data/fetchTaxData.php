<?php
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT id, firstName, lastName, surname, rfc, socialName, tradeName, address, curp FROM tax_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rfc']) . "</td>";
        echo "<td>" . htmlspecialchars($row['socialName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tradeName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['curp']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-tax-data/update-tax-data.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No hay datos fiscales registrados.</td></tr>";
}
$conn->close();
