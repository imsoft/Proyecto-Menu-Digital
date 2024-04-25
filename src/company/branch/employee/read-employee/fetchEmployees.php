<?php
require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT id, firstName, lastName, surname, email, phone, birthdate, gender FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['birthdate']) . "</td>";
        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-employee/update-employee.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay empleados registrados.</td></tr>";
}
$conn->close();
