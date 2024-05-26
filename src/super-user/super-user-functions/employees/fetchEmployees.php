<?php
require '../../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

$sql = "SELECT e.id, e.firstName, e.lastName, e.surname, e.email, e.phone, e.birthdate, e.gender, c.business_name AS companyName, b.branch_name AS branchName
        FROM employees e
        JOIN companies c ON e.company_id = c.id
        LEFT JOIN branches b ON e.branch_id = b.id";
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
        echo "<td>" . htmlspecialchars($row['companyName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['branchName'] ?? 'No Aplicable') . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-employee.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No hay empleados registrados.</td></tr>";
}
$conn->close();
